<?php
namespace App\Controllers;

use App\Helpers\Datatable;
use App\Helpers\Settings;
use App\Helpers\Helper;
use \Exception;

class Cliente extends Controller
{
    private function cuentaCorriente($clienteId, $desde = null, $hasta = null)
    {
        $pdo = $this->pdo;

        $resumen = [];
        $saldoAcumulado = 0;

        if ($desde) {
            $sql = "
                SELECT
                    SUM(debe-haber)
                FROM
                    cliente_cc
                WHERE
                    cliente_id = ?
                AND
                    fecha < ?
            ";
            $sth = $pdo->prepare($sql);
            $sth->execute([$clienteId, $desde]);
            if ($saldo = $sth->fetch()) {
                $saldoAcumulado = (float) $saldo[0];
            }
        }

        if ($saldoAcumulado) {
            $resumen[] = [
                'fecha' => null,
                'concepto' => 'Saldo anterior',
                'debe' => 0,
                'haber' => 0,
                'saldo' => $saldoAcumulado,
                'presupuesto_id' => null,
            ];
        }

        $sql = "
            SELECT
                c.id AS id,
                c.fecha AS fecha,
                c.cliente_id AS cliente_id,
                c.concepto AS concepto,
                c.debe AS debe,
                c.haber AS haber,
                (c.debe - c.haber) AS saldo,
                c.presupuesto_id AS presupuesto_id,
                p.cliente_id AS presupuesto_cliente_id,
                l.codigo AS presupuesto_cliente_codigo,
                l.nombre AS presupuesto_cliente_nombre,
                c.recibo_id AS recibo_id
            FROM
                cliente_cc c
            LEFT JOIN
                presupuesto p ON c.presupuesto_id = p.id
            LEFT JOIN
                cliente l ON p.cliente_id = l.id
            WHERE
                c.cliente_id = ?
        ";

        $params = [$clienteId];

        if ($desde) {
            $sql .= " AND c.fecha >= ?";
            $params[] = $desde;
        }

        if ($hasta) {
            $params[] = $hasta;
            $sql .= " AND c.fecha <= ?";
        }

        $sth = $pdo->prepare($sql);
        $sth->execute($params);

        foreach ($sth->fetchAll(\PDO::FETCH_ASSOC) as $detalle) {
            $debe = (float)$detalle['debe'];
            $haber = (float)$detalle['haber'];
            $saldoAcumulado += $debe - $haber;
            $fecha = Helper::formatDate($detalle['fecha'], 'd/m/Y');
            $presupuestoId = (int)$detalle['presupuesto_id'] ?: null;
            $reciboId = (int)$detalle['recibo_id'] ?: null;

            $presupuesto = null;
            if ($presupuestoId) {
                $presupuesto = [
                    'id' => $presupuestoId,
                    'cliente' => [
                        'id' => (int) $detalle['presupuesto_cliente_id'],
                        'codigo' => (int) $detalle['presupuesto_cliente_codigo'],
                        'nombre' => trim($detalle['presupuesto_cliente_nombre']),
                    ]
                ];
            }

            $recibo = null;
            if ($reciboId) {
                $recibo = [
                    'id' => $reciboId,
                ];
            }

            $resumen[] = [
                'id' => $detalle['id'],
                'fecha' => $fecha,
                'concepto' => $detalle['concepto'],
                'debe' => $debe,
                'haber' => $haber,
                'saldo' => $saldoAcumulado,
                'presupuesto' => $presupuesto,
                'recibo' => $recibo,
            ];
        }

        if (!$desde) {
            $resumen = array_slice($resumen, -10);
        }

        return $resumen;
    }

    private function descuentos($clienteId)
    {
        $pdo = $this->pdo;
        $sth = $pdo->prepare('
            SELECT d.*, CASE WHEN c.cliente_id IS NULL THEN 0 ELSE 1 END AS seleccionado
            FROM descuento d
            LEFT JOIN cliente_descuento c ON c.cliente_id = ? AND d.id = c.descuento_id
            ORDER BY d.descripcion
        ');
        $exec = $sth->execute([$clienteId]);
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function createOrEdit($id=0)
    {
        $db = $this->db;
        $usuario = $this->app->usuario;

        $dias = [
            1   => 'Domingo',
            2   => 'Lunes',
            4   => 'Martes',
            8   => 'Miércoles',
            16  => 'Jueves',
            32  => 'Viernes',
            64  => 'Sábado',
        ];

        if ($id > 0) {
            $cliente = $db->cliente[$id];

            if (!$cliente) {
                throw new Exception("No se encontró el cliente con ID $id.");
            }
        } else {
            $cliente = null;
            $cc = null;
        }

        $args = [
            'cliente' => $cliente,
            'formas_pago' => $db->forma_pago->fetchPairs('id', 'descripcion'),
            'grupos' => $db->grupo->fetchPairs('id', 'nombre'),
            'clientes' => $db->cliente->fetchPairs('id', 'nombre'),
            'dias' => $dias,
        ];

        $this->render('cliente/form.twig', $args);
    }

    public function index()
    {
        $this->render('cliente/index.twig');
    }

    public function create()
    {
        $this->createOrEdit();
    }

    public function edit($id)
    {
        $this->createOrEdit($id);
    }

    public function save()
    {
        $db = $this->db;

        $post = $this->request->post();
        $id = (int) $this->request->post('id');

        $diasVisita = 0;
        if (isset($post['dias_visita'])) {
            $diasVisita = array_sum((array)$post['dias_visita']);
        }

        $values = [
            'codigo' => $post['codigo'],
            'nombre' => $post['nombre'],
            'razon' => $post['razon'],
            'domicilio' => $post['domicilio'],
            'localidad' => $post['localidad'],
            'cp' => $post['cp'],
            'domicilio_entrega' => $post['domicilio-entrega'],
            'localidad_entrega' => $post['localidad-entrega'],
            'cp_entrega' => $post['cp-entrega'],
            'telefono' => $post['telefono'],
            'email' => $post['email'],
            'cuit' => $post['cuit'],
            'forma_pago_id' => (int) $post['forma-pago'],
            'grupo_id' => (int) $post['grupo'],
            'notas' => $post['notas'],
            'adv' => $post['adv'],
            'dias_visita' => $diasVisita,
        ];

        try {
            if ($id === 0) {
                $cliente = $db->cliente->insert($values);
            } else {
                $cliente = $db->cliente[$id];
                $cliente->update($values);
            }
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        $this->app->flash('success', "Los datos del cliente '" . $values['nombre'] . "' fueron actualizados");
        $this->responseJson([
            'success' => true
        ]);
    }

    public function delete($id)
    {
        $db = $this->db;

        try {
            $cliente = $db->cliente[$id];

            if ($cliente) {
                if ($cliente->presupuesto()->count('*') > 0) {
                    throw new Exception('No se puede eliminar el cliente porque tiene presupuestos asociados');
                } else {
                    $affected = $cliente->delete();
                }
            } else {
                throw new Exception('No se encontró el cliente');
            }

            $this->responseJson([
                'success' => true,
            ]);
        } catch (Exception $e) {
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function datatable()
    {
        if (!$this->request->isAjax()) {
            return;
        }

        $app = $this->app;

        $dt = new Datatable(Settings::get('db'), 'v_cliente', 'id');
        $dt
            ->addColumn('id', 'DT_RowId', function ($d, $row) {
                return 'row_' . $d;
            })
            ->addColumn('id')
            ->addColumn('codigo')
            ->addColumn('nombre', null, function ($d, $row) use ($app) {
                return '<a href="' . $app->urlFor('Cliente:edit', ['id' => $row['id']]) . '">' . $d . '</a>';
            })
            ->addColumn('localidad')
            ->addColumn('saldo')
            ->addColumn('id', 'accion', function ($d, $row) use ($app) {
                $t  = '<div class="btn-group pull-right">';
                $t .=   '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
                $t .=     '<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>';
                $t .=   '</button>';
                $t .=   '<ul class="dropdown-menu">';
                $t .=     '<li><a href="#" data-id="' . $d . '" class="delete"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>';
                $t .=   '</ul>';
                $t .= '</div>';
                return $t;
            });

        $dt->json();
    }

    public function all()
    {
        $db = $this->db;
        $request = $this->request;

        $q = trim($request->get('q'));
        $l = (int) $request->get('l');

        $clientes = $db
            ->cliente
            ->select('cliente.id, cliente.nombre, v_cliente_saldo:saldo, grupo.nombre AS grupo, grupo.descuento');

        if (strlen($q) > 0) {
            $clientes->where('cliente.nombre LIKE ?', '%' . $q . '%');
        }

        if ($l > 0) {
            $clientes->limit($l);
        }

        $clientes->order('cliente.id');

        $this->responseJson([
            'data' => Helper::serializeResult($clientes)
        ]);
    }

    public function find($id)
    {
        $db = $this->db;
        $request = $this->request;

        $cliente = $db
            ->cliente
            ->select('cliente.*, v_cliente_saldo:saldo, grupo.nombre AS grupo, grupo.descuento')
            ->where('cliente.id = ?', $id)
            ->fetch();

        if ($cliente) {
            $this->responseJson([
                'success' => true,
                'cliente' => [
                    'id' => (int) $cliente['id'],
                    'nombre' => $cliente['nombre'],
                    'razon' => $cliente['razon'],
                    'domicilio' => $cliente['domicilio'],
                    'localidad' => $cliente['localidad'],
                    'cp' => $cliente['cp'],
                    'grupo_id' => (int) $cliente['grupo_id'],
                    'grupo' => $cliente['grupo'],
                    'descuento' => (float) $cliente['descuento'],
                    'saldo' => (float) $cliente['saldo'],
                    'adv' => $cliente['adv'],
                    'notas' => $cliente['notas'],
                ]
            ]);
        } else {
            $this->responseJson([
                'success' => false,
                'message' => "No se encontró el cliente con ID $id",
            ]);
        }
    }

    public function printCC($id)
    {
        $db = $this->db;
        $cliente = $db->cliente[$id];

        if (!$cliente) {
            throw new Exception("No se encontró el cliente con ID $id");
        }

        $request = $this->request;
        $desde = trim($request->get('desde'));
        $hasta = trim($request->get('hasta'));

        if ($desde && $desde = \DateTime::createFromFormat('d/m/Y', $desde)) {
            $desde = $desde->format('Y-m-d');
        } else {
            $desde = null;
        }

        if ($hasta && $hasta = \DateTime::createFromFormat('d/m/Y', $hasta)) {
            $hasta = $hasta->format('Y-m-d');
        } else {
            $hasta = null;
        }

        $resumen = $this->cuentaCorriente((int) $id, $desde, $hasta);

        $this->render('cliente/print_cc.twig', [
            'desde' => $desde,
            'hasta' => $hasta,
            'cliente' => $cliente,
            'resumen' => $resumen,
        ]);
    }

    public function cc($id)
    {
        $request = $this->request;
        $desde = trim($request->get('desde'));
        $hasta = trim($request->get('hasta'));

        if ($desde && $desde = \DateTime::createFromFormat('d/m/Y', $desde)) {
            $desde = $desde->format('Y-m-d');
        } else {
            $desde = null;
        }

        if ($hasta && $hasta = \DateTime::createFromFormat('d/m/Y', $hasta)) {
            $hasta = $hasta->format('Y-m-d');
        } else {
            $hasta = null;
        }

        $resumen = $this->cuentaCorriente((int) $id, $desde, $hasta);
        $this->render('cliente/_table_cc.twig', ['resumen' => $resumen]);
    }
}
