<?php
namespace App\Controllers;

use App\Helpers\Datatable;
use App\Helpers\Settings;
use App\Helpers\Helper;
use \Exception;

class Caja extends Controller
{
    public function index()
    {
        $this->render('/caja/index.twig');
    }

    public function datatableMovimientos()
    {
        if (!$this->request->isAjax()) {
            return;
        }

        $usuario = $this->usuario;
        $where = 'caja_cierre_id IS NULL';

        $dt = new Datatable(Settings::get('db'), 'v_caja', 'id', $where);

        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
        ->addColumn('id')
        ->addColumn('fecha', null, function ($d, $row) {
            return date('d/m/y', strtotime($d));
        })
        ->addColumn('concepto_descripcion')
        ->addColumn('detalle')
        ->addColumn('cobrador_nombre')
        ->addColumn('cliente_codigo', 'cliente', function ($d, $row) {
            return "$d - $row[cliente_nombre]";
        })
        ->addColumn('cliente_nombre')
        ->addColumn('entrada', null, function ($d, $row) {
            return '<p class="text-success">$ ' . number_format((float)$d, 2, ',', '.') . '</p>';
        })
        ->addColumn('salida', null, function ($d, $row) {
            return '<p class="text-danger">$ ' . number_format((float)$d, 2, ',', '.') . '</p>';
        });

        echo $dt->json();
    }

    public function datatableCierres()
    {
        if (!$this->request->isAjax()) {
            return;
        }

        $usuario = $this->usuario;
        $where = '';

        // Si no es administrador, solo puede ver los cierre que realizó
        if (!$usuario->esAdministrador) {
            $where .= 'usuario_id = ' . $usuario->id;
        }

        $app = $this->app;
        $dt = new Datatable(Settings::get('db'), 'v_caja_cierre', 'id', $where);
        $dt
            ->addColumn('id', 'DT_RowId', function ($d, $row) {
                return 'row_' . $d;
            })
            ->addColumn('id')
            ->addColumn('fecha', null, function ($d, $row) {
                return date('d/m/y', strtotime($d));
            })
            ->addColumn('usuario_nombre_completo')
            ->addColumn('id', 'accion', function ($d, $row) use ($app) {
                $t  = '<a class="btn btn-default" href="' . $app->urlFor('Caja:printCierre', ['id' => $d]) . '" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
                return $t;
            });

        echo $dt->json();
    }

    public function movimiento()
    {
        $cobradores = $this->db->cobrador->fetchPairs('id', 'nombre');
        $this->render('/caja/movimiento.twig', [
            'cobradores' => $cobradores
        ]);
    }

    public function saveMovimiento()
    {
        $db = $this->db;
        $request = $this->request;

        $tipo = $request->post('movimiento-tipo');
        $cobradorId = (int)$request->post('movimiento-cobrador');
        $detalle = $request->post('movimiento-detalle');
        $importe = (float)$request->post('movimiento-importe');

        try {
            $movimiento = $db->caja->insert([
                'fecha' => new \NotORM_Literal('NOW()'),
                'concepto' => 'E',
                'detalle' => $detalle,
                'tipo' => $tipo,
                'importe' => $importe,
                'cobrador_id' => $cobradorId,
            ]);

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

    public function cierre()
    {
        $db = $this->db;
        $usuario = $this->usuario;

        $db->transaction = 'BEGIN';

        try {
            // Genero un cierre de caja
            $cierre = $db->caja_cierre->insert([
                'fecha' => new \NotORM_Literal('NOW()'),
                'usuario_id' => $usuario->id,
            ]);

            $cierreId = $cierre['id'];

            // Selecciono los movimientos de caja
            $movimientos = $db->caja('caja_cierre_id', null);

            // Actualizo la caja
            $movimientos->update([
                'caja_cierre_id' => $cierreId,
            ]);

            $db->transaction = 'COMMIT';
            $this->responseJson([
                'success' => true,
                'id' => $cierreId
            ]);
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function printCierre($id)
    {
        $pdo = $this->pdo;

        # Cierre de caja
        $sth = $pdo->prepare('SELECT * FROM caja_cierre WHERE id=:id');
        $sth->execute(['id'=> $id]);
        $cierre = $sth->fetch();

        # Movimientos de la caja
        $sth = $pdo->prepare('SELECT * FROM v_caja WHERE caja_cierre_id=:id');
        $sth->execute(['id'=> $id]);
        $detalle = $sth->fetchAll();

        # Fechas "desde" y "hasta"
        $sth = $pdo->prepare('SELECT MAX(fecha) AS desde, MIN(fecha) AS hasta FROM caja WHERE caja_cierre_id=:id');
        $sth->execute(['id'=> $id]);
        $row = $sth->fetch();
        $desde = $row['desde'];
        $hasta = $row['hasta'];

        $sth = $pdo->prepare("
            SELECT
                SUM(CASE tipo WHEN 'E' THEN importe ELSE 0 END) AS entrada,
                SUM(CASE tipo WHEN 'S' THEN importe ELSE 0 END) AS salida
            FROM
                caja
            WHERE
                caja_cierre_id=:id
        ");
        $sth->execute(['id'=> $id]);
        $row = $sth->fetch();
        $total['entrada'] = (float) $row['entrada'];
        $total['salida'] = (float) $row['salida'];

        $sth = $pdo->prepare("
            SELECT
            	c.cobrador_id,
            	b.nombre AS cobrador,
            	SUM(IF(c.concepto = 'E', IF(c.tipo='E', c.importe, -c.importe), 0)) AS efectivo,
            	SUM(IF(c.concepto = 'C', IF(c.tipo='E', c.importe, -c.importe), 0)) AS cheques
            FROM
            	caja c
            JOIN
            	cobrador b ON c.cobrador_id = b.id
            WHERE
            	c.caja_cierre_id=:id
            GROUP BY
                c.cobrador_id, b.nombre
        ");
        $sth->execute(['id'=> $id]);
        $cobradores = $sth->fetchAll();

        $params = [
            'cierre'        => $cierre,
            'desde'         => $desde,
            'hasta'         => $hasta,
            'detalle'       => $detalle,
            'cobradores'    => $cobradores
        ];

        $this->render('/caja/print.twig', $params);
    }

    public function recibo()
    {
        $db = $this->db;

        $clientes = $db->cliente->fetchPairs('id', "CONCAT('(', codigo, ') ', nombre)");
        $bancos = $db->banco->fetchPairs('id', 'nombre');
        $cobradores = $db->cobrador->fetchPairs('id', 'nombre');

        $this->render('caja/recibo_form.twig', [
            'clientes' => $clientes,
            'bancos' => $bancos,
            'cobradores' => $cobradores
        ]);
    }

    public function viewRecibo($id)
    {
        $db = $this->db;
        $id = (int)$id;
        $recibo = $db->recibo[$id];
        $cheques = $db->cheque('recibo_id', $id);

        $this->render('caja/recibo_view.twig', [
            'recibo' => $recibo,
            'cheques' => $cheques,
        ]);
    }

    public function saveRecibo()
    {
        $db = $this->db;
        $request = $this->request;

        $clienteId = (int)$request->post('cliente');
        $cobradorId = (int)$request->post('cobrador');
        $efectivo = (float)$request->post('total-efectivo');
        $deposito = (float)$request->post('total-deposito');
        $mercaderia = (float)$request->post('total-mercaderia');

        $chequeNumero = $request->post('detalle-cheque-numero');
        $chequeBanco = $request->post('detalle-cheque-banco');
        $chequeCuit = $request->post('detalle-cheque-cuit');
        $chequeFecha = $request->post('detalle-cheque-fecha');
        $chequeImporte = $request->post('detalle-cheque-importe');

        $totalCheques = 0;
        foreach ((array)$chequeImporte as $d) {
            $totalCheques += (float)$d;
        }

        $db->transaction = 'BEGIN';

        try {
            $recibo = $db->recibo->insert([
                'fecha'         => new \NotORM_Literal('NOW()'),
                'cliente_id'    => $clienteId,
                'cobrador_id'   => $cobradorId,
                'efectivo'      => $efectivo,
                'cheques'       => $totalCheques,
            ]);

            $reciboId = (int)$recibo['id'];

            if ($efectivo > 0) {
                $db->caja->insert([
                    'fecha' => new \NotORM_Literal('NOW()'),
                    'concepto' => 'E',
                    'detalle' => "Recibo Nº $reciboId",
                    'tipo' => 'E',
                    'importe' => $efectivo,
                    'recibo_id' => $reciboId,
                    'cobrador_id' => $cobradorId,
                    'cliente_id' => $clienteId,
                ]);
            }

            $totalCheques = 0;
            foreach ((array)$chequeNumero as $i => $d) {
                $importe = (float)$chequeImporte[$i];
                $totalCheques += $importe;
                $fecha = \DateTime::createFromFormat('d/m/Y', $chequeFecha[$i]);
                $bancoId = (int)$chequeBanco[$i];
                $banco = $db->banco[$bancoId];

                $cheque = $db->cheque->insert([
                    'numero' => (int)$d,
                    'banco_id' => $bancoId,
                    'cuit' => $chequeCuit[$i],
                    'fecha' => $fecha,
                    'importe' => $importe,
                    'cliente_id' => $clienteId,
                    'recibo_id' => $reciboId,
                    'estado' => 'C',
                ]);

                $chequeId = (int)$cheque['id'];

                $db->caja->insert([
                    'fecha' => new \NotORM_Literal('NOW()'),
                    'concepto' => 'C',
                    'detalle' => "Recibo Nº $reciboId ($banco[nombre] Nº $cheque[numero])",
                    'tipo' => 'E',
                    'importe' => $importe,
                    'recibo_id' => $reciboId,
                    'cobrador_id' => $cobradorId,
                    'cliente_id' => $clienteId,
                ]);
            }

            $total = $efectivo + $deposito + $mercaderia + $totalCheques;

            $db->cliente_cc->insert([
                'fecha' => new \NotORM_Literal('CURDATE()'),
                'cliente_id' => $clienteId,
                'concepto' => 'Recibo Nº ' . $reciboId,
                'haber' => $total,
                'recibo_id' => $reciboId,
            ]);

            $db->transaction = 'COMMIT';
            $this->responseJson([
                'success' => true,
            ]);
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function deleteRecibo($id)
    {
        $db = $this->db;
        $id = (int)$id;

        $tieneCajaCerrada = $db->caja('recibo_id = ? AND caja_cierre_id IS NOT NULL', $id)->count('*');
        if ($tieneCajaCerrada) {
            $this->responseJson([
                'success' => false,
                'message' => 'El recibo no se puede eliminar porque pertenece a una caja cerrada',
            ]);
            return;
        }

        try {
            $recibo = $db->recibo[(int)$id];
            $recibo->delete();
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
}
