<?php
namespace App\Controllers;

use Datatable;
use Settings;
use Helper;
use \Exception;
use \DateTime;
use NotORM_Literal;
use Permiso;

class Stock extends Controller
{
    public function createMovimiento()
    {
        $db = $this->db;
        $depositos = $db->deposito->fetchPairs('id', 'nombre');

        $this->render('stock/movimiento.twig', [
            'depositos' => $depositos,
        ]);
    }

    public function saveMovimiento()
    {
        $db = $this->db;
        $pdo = $this->pdo;

        $request = $this->request;
        $usuarioId = $this->usuario->id;

        $depositoId = (int)$request->post('deposito');
        $motivo = trim((string)$request->post('motivo'));
        $detalleArticuloId = $request->post('detalle-articulo-id');
        $detalleEntrada = $request->post('detalle-entrada');
        $detalleSalida = $request->post('detalle-salida');

        $db->transaction = 'BEGIN';
        try {
            foreach ($detalleArticuloId as $i => $articuloId) {
                $tipo = 'E';
                $cantidad = (int)$detalleEntrada[$i];

                if ($cantidad === 0) {
                    $tipo = 'S';
                    $cantidad = (int)$detalleSalida[$i];
                }

                if ($cantidad > 0) {
                    $articulo = $db->articulo->select('precio, costo')[(int)$articuloId];
                    $db->stock_movimiento()->insert([
                        'fecha'         => new NotORM_Literal('NOW()'),
                        'descripcion'   => $motivo,
                        'deposito_id'   => $depositoId,
                        'articulo_id'   => (int)$articuloId,
                        'tipo'          => $tipo,
                        'cantidad'      => $cantidad,
                        'costo'         => (float)$articulo['costo'],
                        'precio'        => (float)$articulo['precio'],
                        'usuario_id'    => $usuarioId,
                    ]);
                }
            }

            $db->transaction = 'COMMIT';
            $this->app->flash('success', 'El movimiento de stock fue generado');

            $this->responseJson([
                'success' => true
            ]);
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';

            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function indexInventario()
    {
    }

    public function createInventario()
    {
        $db = $this->db;
        $depositos = $db->deposito->fetchPairs('id', 'nombre');

        $this->render('stock/inventario.twig', [
            'depositos' => $depositos,
        ]);
    }

    public function saveInventario()
    {
        $db = $this->db;
        $pdo = $this->pdo;

        $request = $this->request;
        $usuarioId = $this->usuario->id;

        $depositoId = (int) $request->post('deposito-id');
        $motivo = $request->post('motivo');
        $detalleArticuloId = $request->post('detalle-articulo-id');
        $detalleCantidad = $request->post('detalle-cantidad');

        $db->transaction = 'BEGIN';
        try {
            $inventario = $db->stock_inventario()->insert([
                'fecha' => new NotORM_Literal('NOW()'),
                'usuario_id' => $usuarioId,
                'deposito_id' => $depositoId,
                'motivo' => $motivo,
            ]);

            $inventarioId = $inventario['id'];
            $concepto = "Inventario Nº $inventarioId";

            foreach ($detalleArticuloId as $i => $articuloId) {
                $db->stock_inventario_detalle()->insert([
                    'stock_inventario_id' => $inventarioId,
                    'articulo_id' => (int) $articuloId,
                    'cantidad' => (int) $detalleCantidad[$i],
                ]);
            }

            $sth = $pdo->prepare("
                INSERT INTO
                    stock_movimiento(fecha, descripcion, deposito_id, articulo_id, tipo, cantidad, costo, precio, usuario_id)
                SELECT
                    i.fecha,
                    CONCAT('Inventario Nº ', i.id, ': ', i.motivo),
                    i.deposito_id,
                    d.articulo_id,
                    IF(d.cantidad - IFNULL(s.cantidad, 0) > 0, 'E', 'S'),
                    ABS(d.cantidad - IFNULL(s.cantidad, 0)),
                    a.costo,
                    a.precio,
                    i.usuario_id
                FROM stock_inventario_detalle d
                JOIN stock_inventario i ON d.stock_inventario_id = i.id
                JOIN articulo a ON d.articulo_id = a.id
                LEFT JOIN v_stock_deposito s ON a.id = s.articulo_id AND i.deposito_id = s.deposito_id
                WHERE i.id = ?
            ");
            $sth->execute([$inventarioId]);

            $db->transaction = 'COMMIT';
            $this->app->flash('success', 'El inventario de stock fue guardado');
            $this->responseJson([
                'success' => true
            ]);
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function indexTransferencia()
    {
    }

    public function createTransferencia()
    {
        $db = $this->db;
        $depositos = $db->deposito->fetchPairs('id', 'nombre');

        $this->render('stock/transferencia.twig', [
            'depositos' => $depositos,
        ]);
    }

    public function saveTransferencia()
    {
        $db = $this->db;
        $pdo = $this->pdo;

        $request = $this->request;
        $usuarioId = $this->usuario->id;

        $origenId = (int) $request->post('deposito-origen-id');
        $destinoId = (int) $request->post('deposito-destino-id');
        $motivo = $request->post('motivo');
        $detalleArticuloId = $request->post('detalle-articulo-id');
        $detalleCantidad = $request->post('detalle-cantidad');

        $db->transaction = 'BEGIN';
        try {
            $transferencia = $db->stock_transferencia()->insert([
                'fecha' => new NotORM_Literal('NOW()'),
                'usuario_id' => $usuarioId,
                'deposito_origen_id' => $origenId,
                'deposito_destino_id' => $destinoId,
                'motivo' => $motivo,
            ]);

            $transferenciaId = $transferencia['id'];

            foreach ($detalleArticuloId as $i => $articuloId) {
                $db->stock_transferencia_detalle()->insert([
                    'stock_transferencia_id' => $transferenciaId,
                    'articulo_id' => (int) $articuloId,
                    'cantidad' => (int) $detalleCantidad[$i],
                ]);
            }

            $sth = $pdo->prepare("
                INSERT INTO
                    stock_movimiento(fecha, descripcion, deposito_id, articulo_id, tipo, cantidad, costo, precio, usuario_id)
                SELECT
                    t.fecha,
                    CONCAT('Transferencia Nº ', t.id, ': ', t.motivo),
                    t.deposito_origen_id,
                    d.articulo_id,
                    'S',
                    d.cantidad,
                    a.costo,
                    a.precio,
                    t.usuario_id
                FROM stock_transferencia_detalle d
                JOIN stock_transferencia t ON d.stock_transferencia_id = t.id
                JOIN articulo a ON d.articulo_id = a.id
                WHERE t.id = ?
            ");
            $sth->execute([$transferenciaId]);

            $sth = $pdo->prepare("
                INSERT INTO
                    stock_movimiento(fecha, descripcion, deposito_id, articulo_id, tipo, cantidad, costo, precio, usuario_id)
                SELECT
                    t.fecha,
                    CONCAT('Transferencia Nº ', t.id, ': ', t.motivo),
                    t.deposito_destino_id,
                    d.articulo_id,
                    'E',
                    d.cantidad,
                    a.costo,
                    a.precio,
                    t.usuario_id
                FROM stock_transferencia_detalle d
                JOIN stock_transferencia t ON d.stock_transferencia_id = t.id
                JOIN articulo a ON d.articulo_id = a.id
                WHERE t.id = ?
            ");
            $sth->execute([$transferenciaId]);

            $db->transaction = 'COMMIT';
            $this->app->flash('success', 'El inventario de stock fue guardado');
            $this->responseJson([
                'success' => true
            ]);
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
