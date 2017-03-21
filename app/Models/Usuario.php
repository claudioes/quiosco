<?php
namespace App\Models;

class Usuario
{
    private $db;
    public $id;
    public $nombre;
    public $apellido;
    public $usuario;
    public $esAdministrador = false;
    public $esValido = false;
    public $estaActivo = false;
    public $horarioDesde;
    public $horarioHasta;
    public $dias;
    private $permisos = [];

    public function __construct(\PDO $pdo)
    {
        $this->db = new \NotORM($pdo);

        if (isset($_SESSION['usuario_id'])) {
            $usuario = $this->db->usuario[(int) $_SESSION['usuario_id']];
            if ($usuario) {
                $this->cargar($usuario);
            }
        }
    }

    public function autenticar($usuario, $password)
    {
        $usuario = $this->db->usuario([
            'usuario' => $usuario,
            'password' => md5($password),
        ])->fetch();

        if ($usuario) {
            $this->cargar($usuario);
        } else {
            $this->limpiar();
        }
    }

    public function limpiar()
    {
        $this->id = null;
        $this->nombre = null;
        $this->apellido = null;
        $this->usuario = null;
        $this->esAdministrador = false;
        $this->estaActivo = false;
        $this->esValido = false;
        $this->permisos = [];
        $this->horarioDesde = null;
        $this->horarioHasta = null;
        $this->dias = 0;
        unset($_SESSION['usuario_id']);
    }

    private function cargar($data)
    {
        $this->id = (int) $data['id'];
        $this->nombre = $data['nombre'];
        $this->apellido = $data['apellido'];
        $this->usuario = $data['usuario'];
        $this->esAdministrador = (bool) $data['administrador'];
        $this->estaActivo = (bool) $data['activo'];

        if ($data['horario_desde']) {
            $this->horarioDesde = \DateTime::createFromFormat('H:i:s', $data['horario_desde']);
        } else {
            $this->horarioDesde = null;
        }

        if ($data['horario_hasta']) {
            $this->horarioHasta = \DateTime::createFromFormat('H:i:s', $data['horario_hasta']);
        } else {
            $this->horarioHasta = null;
        }

        $this->dias =  (int) $data['dias'];
        $this->esValido = true;
        $this->permisos = [];

        if (!$this->esAdministrador) {
            foreach ($this->db->usuario_permiso('usuario_id', $this->id) as $permiso) {
                $this->permisos[] = $permiso['permiso_id'];
            }
        }

        $_SESSION['usuario_id'] = $this->id;
    }

    public function cumpleHorario()
    {
        $ahora = new \DateTime("now");

        // Por defecto, si no se definió ningún límite, está habilitado para usarlo en cualquier momento
        $diaHabilitado = true;
        $horarioHabilitado = true;

        // Se definió un día de uso
        if ($this->dias) {
            // Los días se guardan usando la técnica bitwise (http://sqlfool.com/2009/02/bitwise-operations/)
            // Cada día está representado por una potencia de 2
            $diaHabilitado = $this->dias & pow(2, (int)$ahora->format('w'));
        }

        // Se definió un rango horario de uso
        if ($this->horarioDesde && $this->horarioHasta) {
            // El horario actual está dentro del rango de horarios habilitado
            $horarioHabilitado = $ahora >= $this->horarioDesde && $ahora <= $this->horarioHasta;
        }

        return $diaHabilitado && $horarioHabilitado;
    }

    public function puede($permiso, $todo = false)
    {
        if (!$this->esValido) {
            return false;
        }

        // El administrador tiene acceso a todo
        // Si no se definió un permiso devuelve verdadero (puedo hacer nada? obvio!)
        if ($this->esAdministrador || !$permiso) {
            return true;
        }

        // Si el usuario no tiene definido ningun permiso, no tiene acceso a nada
        if (count($this->permisos) === 0) {
            return false;
        }

        // Si es un string, pueden venir varios permisos separados por coma
        if (is_string($permiso)) {
            $permiso = preg_split('/\s*,\s*/', trim($permiso));
        }

        // Un solo permiso
        if (count($permiso) === 1) {
            return in_array($permiso[0], $this->permisos);
        }

        // Varios permisos
        // Tiene que cumplir todo
        if ($todo) {
            return count(array_intersect($permiso, $this->permisos)) == count($target);
        }

        // Varios permisos
        // Tiene que cumplir al menos uno
        return count(array_intersect($permiso, $this->permisos)) > 0;
    }
}
