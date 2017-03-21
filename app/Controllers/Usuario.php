<?php
namespace App\Controllers;

use Datatable;
use Settings;
use Helper;
use \Exception;
use \DateTime;
use NotORM_Literal;

class Usuario extends Controller
{
    private function permisos($usuarioId = null)
    {
        $pdo = $this->pdo;
        $sth = $pdo->prepare('
            SELECT p.*, CASE WHEN u.usuario_id IS NULL THEN 0 ELSE 1 END AS seleccionado
            FROM permiso p
            LEFT JOIN usuario_permiso u ON u.usuario_id = ? AND p.id = u.permiso_id
            ORDER BY p.descripcion
        ');
        $exec = $sth->execute([(int) $usuarioId]);
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function index()
    {
        $this->render('/usuario/index.twig');
    }

    public function create()
    {
        // $permisos = $this->db->permiso->fetchPairs('id', 'descripcion');
        $cobradores = $this->db->cobrador->fetchPairs('id', 'nombre');
        $categorias = $this->db->cliente_categoria->fetchPairs('id', 'nombre');
        $dias = [
            '1' => [
                'nombre' => 'Domingo',
                'seleccionado' => 0,
            ],
            '2' => [
                'nombre' => 'Lunes',
                'seleccionado' => 0,
            ],
            '4' => [
                'nombre' => 'Martes',
                'seleccionado' => 0
            ],
            '8' => [
                'nombre' => 'Miercoles',
                'seleccionado' => 0
            ],
            '16' => [
                'nombre' => 'Jueves',
                'seleccionado' => 0
            ],
            '32' => [
                'nombre' => 'Viernes',
                'seleccionado' => 0
            ],
            '64' => [
                'nombre' => 'Sábado',
                'seleccionado' => 0
            ],
        ];


        $this->render('/usuario/form.twig', [
            'permisos' => $this->permisos(),
            'cobradores' => $cobradores,
            'categorias' => $categorias,
            'dias' => $dias,
        ]);
    }

    public function edit($id)
    {
        if (!$id) {
            throw new Exception("No se definió el ID del usuario");
        } else {
            $db = $this->db;
            $data = $db->usuario[$id];
            if (!$data) {
                throw new Exception("No se encontró el usuario ID $id");
            } else {
                //$permisos = $this->db->permiso->order('descripcion');
                $cobradores = $this->db->cobrador->fetchPairs('id', 'nombre');
                $categorias = $this->db->cliente_categoria->fetchPairs('id', 'nombre');
                $dias = (int)$data['dias'];
                $dias = [
                    '1' => [
                        'nombre' => 'Domingo',
                        'seleccionado' => $dias & 1,
                    ],
                    '2' => [
                        'nombre' => 'Lunes',
                        'seleccionado' => $dias & 2,
                    ],
                    '4' => [
                        'nombre' => 'Martes',
                        'seleccionado' => $dias & 4
                    ],
                    '8' => [
                        'nombre' => 'Miercoles',
                        'seleccionado' => $dias & 8
                    ],
                    '16' => [
                        'nombre' => 'Jueves',
                        'seleccionado' => $dias & 16
                    ],
                    '32' => [
                        'nombre' => 'Viernes',
                        'seleccionado' => $dias & 32
                    ],
                    '64' => [
                        'nombre' => 'Sábado',
                        'seleccionado' => $dias & 64
                    ],
                ];

                $this->render('/usuario/form.twig', [
                    'data'  => $data,
                    'permisos' => $this->permisos($id),
                    'cobradores' => $cobradores,
                    'categorias' => $categorias,
                    'dias' => $dias,
                ]);
            }
        }
    }

    public function changePassword($id)
    {
        if (!$id) {
            throw new Exception("No se definió el ID del usuario");
        } else {
            $db = $this->db;
            $data = $db->usuario[$id];
            if (!$data) {
                throw new Exception("No se encontró el usuario ID $id");
            } else {
                $this->render('/usuario/password.twig', [
                    'data'  => $data
                ]);
            }
        }
    }

    public function datatable()
    {
        if (!$this->request->isAjax()) {
            return;
        }
        $app = $this->app;

        $dt = new Datatable(Settings::get('db'), 'usuario', 'id');
        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
            ->addColumn('usuario', null, function ($d, $row) use ($app) {
                return '<a href="' . $app->urlFor('Usuario:edit', ['id' => $row['id']]) . '">' . $d . '</a>';
            })
            ->addColumn('email')
            ->addColumn('id', 'accion', function ($d, $row) use ($app) {
                $t  = '<div class="btn-group pull-right">';
                $t .=   '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
                $t .=     '<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>';
                $t .=   '</button>';
                $t .=   '<ul class="dropdown-menu">';
                $t .=     '<li><a href="' . $app->urlFor('Usuario:changePassword', ['id' => $d]) . '">Cambiar contraseña</a></li>';
                $t .=     '<li role="separator" class="divider"></li>';
                $t .=     '<li><a href="#" data-id="' . $d . '" class="delete"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>';
                $t .=   '</ul>';
                $t .= '</div>';
                return $t;
            });

        $dt->json();
    }

    public function save()
    {
        $db = $this->db;
        $request = $this->request;

        $id = (int) $request->post('id');
        $nombreUsuario = trim($request->post('usuario'));
        $password = trim($request->post('password'));

        if ($id) {
            $usuario = $db->usuario[$id];
            if (!$usuario) {
                $this->responseJson([
                    'success' => false,
                    'message' => "No encontró el usuario ID $id"
                ]);
                return;
            }
        } else {
            if ($db->usuario('usuario', $nombreUsuario)->count('*')) {
                $this->responseJson([
                    'success' => false,
                    'message' => "Ya existe un usuario con nombre '$nombreUsuario'",
                ]);
                return;
            }

            if (!$password) {
                $this->responseJson([
                    'success' => false,
                    'message' => "Debe ingresar una contraseña",
                ]);
                return;
            }
        }

        $admin = (int) $request->post('admin');
        $permisos = $request->post('permiso');

        if (!$admin && !$permisos) {
            $this->responseJson([
                'success' => false,
                'message' => "Debe definir los permisos del usuario",
            ]);
            return;
        }

        $desde = null;
        if ($request->post('horario-desde')) {
            $desde = DateTime::createFromFormat('H:i', $request->post('horario-desde'));
            if ($desde) {
                $desde = $desde->format('H:i:s');
            }
        }

        $hasta = null;
        if ($request->post('horario-hasta')) {
            $hasta = DateTime::createFromFormat('H:i', $request->post('horario-hasta'));
            if ($hasta) {
                $hasta = $hasta->format('H:i:s');
            }
        }

        $dias = 0;
        foreach ((array)$request->post('dias') as $dia) {
            $dias += (int)$dia;
        }

        $values = [
            'usuario' => $nombreUsuario,
            'nombre' => $request->post('nombre'),
            'apellido' => $request->post('apellido'),
            'email' => $request->post('email'),
            'cobrador_id' => (int)$request->post('cobrador'),
            'cliente_categoria_id' => (int)$request->post('categoria'),
            'administrador' => $admin,
            'activo' => (int)$request->post('activo'),
            'horario_desde' => $desde,
            'horario_hasta' => $hasta,
            'dias' => $dias,
        ];

        if ($id == 0) {
            $values['password'] = md5($password);
        }

        $db->transaction = 'BEGIN';
        try {
            if ($id === 0) {
                $usuario = $db->usuario->insert($values);
            } else {
                $usuario->update($values);
            }

            $id = (int) $usuario['id'];
            $db->usuario_permiso('usuario_id', $id)->delete();

            if (!$admin) {
                foreach ($permisos as $p) {
                    $db->usuario_permiso->insert([
                        'usuario_id' => $id,
                        'permiso_id' => $p,
                    ]);
                }
            }

            $db->transaction = 'COMMIT';
            $this->responseJson([
                'success' => true,
                'id' => $id
            ]);
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function savePassword()
    {
        $db = $this->db;
        $post = $this->request->post();

        $id = (int) $post['id'];

        $usuario= $db->usuario[$id];
        if (!$usuario) {
            $this->responseJson([
                'success' => false,
                'message' => "No encontró el usuario ID $id"
            ]);
            return;
        }

        $password = $post['password'];
        $repeticion = $post['repeticion'];

        if ($password != $repeticion) {
            $this->responseJson([
                'success' => false,
                'message' => "La nueva contraseña no coincide con la repetición"
            ]);
            return;
        }

        try {
            $usuario->update([
                'password' => md5($password)
            ]);

            $this->responseJson([
                'success' => true
            ]);
        } catch (Exception $e) {
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        if (!$id) {
            throw new Exception("No se definió el ID del usuario");
        } else {
            $db = $this->db;
            $usuario = $db->usuario[$id];
            try {
                if (!$usuario) {
                    throw new Exception("No se encontró el usuario ID $id");
                } else {
                    $usuario->delete();
                    $this->responseJson(['success' => true]);
                }
            } catch (Exception $e) {
                $this->responseJson([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
}
