<?php
namespace App\Controllers;

use Datatable;
use Settings;
use Helper;
use \Exception;
use \DateTime;

class Recepcion extends Controller
{
    public function index()
    {
        $this->render('recepcion/index.twig');
    }

    public function create()
    {
        $db = $this->db;
        $proveedores = $db->proveedor->order('nombre');
        $depositos = $db->deposito->fetchPairs('id', 'nombre');
        $comprobantes = [
            'REMITO' => 'Remito',
            'FACTURA' => 'Factura',
        ];

        $this->render('recepcion/form.twig', [
            'proveedores' => $proveedores,
            'comprobantes' => $comprobantes,
            'depositos' => $depositos,
        ]);
    }

    public function view($id)
    {
        $db = $this->db;
        $recepcion = $db->recepcion[(int) $id];

        if ($recepcion) {
            $detalle = $db
                ->recepcion_detalle
                ->select(
                    'recepcion_detalle.articulo_id',
                    'articulo.codigo',
                    'articulo.descripcion',
                    'recepcion_detalle.cantidad',
                    'recepcion_detalle.precio'
                )
                ->where('recepcion_detalle.recepcion_id', (int) $id);

            $proveedor = $recepcion->proveedor;
            $usuario = $recepcion->usuario;
            $deposito = $recepcion->deposito;

            $this->render('recepcion/view.twig', [
                'recepcion' => $recepcion,
                'detalle' => $detalle,
                'proveedor' => $proveedor,
                'usuario' => $usuario,
                'deposito' => $deposito,
            ]);
        }
    }

    public function save()
    {
        $db = $this->db;
        $request = $this->request;

        try {
            $proveedorId = (int) $request->post('proveedor');

            if ($proveedorId === 0) {
                throw new Exception('No se seleccionó ningún proveedor');
            } else {
                $proveedor = $db->proveedor[$proveedorId];
                if ($proveedor === null) {
                    throw new Exception("El proveedor con ID $proveedorId no existe");
                }
            }

            $comprobanteTipo = $request->post('comprobante-tipo');
            $comprobanteNumero = $request->post('comprobante-numero');
            $comprobanteFecha = $request->post('comprobante-fecha');

            if ($comprobanteFecha) {
                $comprobanteFecha = DateTime::createFromFormat('d/m/Y', $comprobanteFecha);
                if (!$comprobanteFecha) {
                    throw new Exception('La fecha del comprobante es incorrecta');
                }
            }

            $depositoId = (int) $request->post('deposito');

            $detalleArticuloId = $request->post('detalle-articulo-id');
            $detalleCantidad = $request->post('detalle-cantidad');
            $detallePrecio = $request->post('detalle-precio');

            if (!$detalleArticuloId || count($detalleArticuloId) === 0) {
                throw new Exception('No se ingresaron artículos al detalle');
            }

            $db->transaction = 'BEGIN';

            try {
                # Cabecera de recepcion
                $recepcion = $db->recepcion()->insert([
                    'fecha' => new \NotORM_Literal("NOW()"),
                    'proveedor_id' => $proveedorId,
                    'comprobante_tipo' => $comprobanteTipo,
                    'comprobante_fecha' => $comprobanteFecha,
                    'comprobante_numero' => $comprobanteNumero,
                    'deposito_id' => $depositoId,
                    'usuario_id' => $this->usuario->id,
                ]);

                $recepcionId = $recepcion['id'];

                # Detalle de recepcion
                foreach ($detalleArticuloId as $i => $articuloId) {
                    $db->recepcion_detalle->insert([
                        'recepcion_id' => $recepcionId,
                        'articulo_id' => (int) $articuloId,
                        'cantidad' => (int) $detalleCantidad[$i],
                        'precio' => (float) $detallePrecio[$i],
                    ]);
                }

                $db->transaction = 'COMMIT';
            } catch (Exception $e) {
                $db->transaction = 'ROLLBACK';
                throw $e;
            }

            $sth = $this->pdo->prepare("
                INSERT INTO
                    stock_movimiento(fecha, descripcion, deposito_id, articulo_id, tipo, cantidad, costo, precio, usuario_id)
                SELECT
                    r.fecha,
                    CONCAT('Recepción Nº ', r.id),
                    r.deposito_id,
                    d.articulo_id,
                    'E',
                    d.cantidad,
                    a.costo,
                    a.precio,
                    r.usuario_id
                FROM recepcion_detalle d
                JOIN recepcion r ON d.recepcion_id = r.id
                JOIN articulo a ON d.articulo_id = a.id
                WHERE r.id = ?
            ");
            $sth->execute([$recepcionId]);

            $this->app->flash('success', "Los datos de la recepción Nº $recepcionId fueron guardados");
            $this->responseJson([
                'success' => true,
                'id' => $recepcionId
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
        $db = $this->db;
        $db->transaction = 'BEGIN';
        try {
            $recepcion = $db->recepcion[$id];

            if ($recepcion === null) {
                throw new Exception("No se encontró la recepción con ID $id");
            } else {
                // Anulo la recepción
                $recepcion->update([
                    'anulado' => true
                ]);

                // Devuelvo el stock
                $items = $recepcion->recepcion_detalle();
                $depositoId = (int)$recepcion['deposito_id'];
                foreach ($items as $item) {
                    $db->stock_movimiento->insert([
                        'fecha'         => new \NotORM_Literal('NOW()'),
                        'descripcion'   => "Anulación de recepción Nº $id",
                        'articulo_id'   => $item['articulo_id'],
                        'deposito_id'   => $depositoId,
                        'cantidad'      => (float)$item['cantidad'],
                        'costo'         => 0,
                        'precio'        => (float)$item['precio'],
                        'tipo'          => 'S',
                        'usuario_id'    => $this->usuario->id,
                    ]);
                }
            }

            $db->transaction = 'COMMIT';
            $this->responseJson([
                'success' => true,
            ]);
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function datatable()
    {
        if (!$this->request->isAjax()) {
            return;
        }
        $app = $this->app;

        $dt = new Datatable(Settings::get('db'), 'v_recepcion', 'id', 'NOT anulado');
        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
            ->addColumn('id')
            ->addColumn('fecha', null, function ($d, $row) {
                return date('d/m/y', strtotime($d));
            })
            ->addColumn('proveedor_id')
            ->addColumn('proveedor_nombre')
            ->addColumn('comprobante_tipo', 'comprobante', function ($d, $row) {
                return "$d $row[comprobante_numero]";
            })
            ->addColumn('comprobante_numero')
            ->addColumn('comprobante_fecha', null, function ($d, $row) {
                return date('d/m/y', strtotime($d));
            })
            ->addColumn('deposito_nombre')
            ->addColumn('usuario_nombre')
            ->addColumn('id', 'accion', function ($d, $row) use ($app) {
                $t  = '<div class="btn-group" role="group" style="display: flex;">';
                $t .=   '<a class="btn btn-default view" href="' .  $app->urlFor('Recepcion:view', ['id' => $d]) . '">Ver</a>';
                $t .=   '<div class="btn-group pull-right" role="group">';
                $t .=     '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
                $t .=       '<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>';
                $t .=     '</button>';
                $t .=     '<ul class="dropdown-menu">';
                $t .=       '<li><a href="#" data-id="' . $d . '" class="delete"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>';
                $t .=     '</ul>';
                //$t .=   '</div>';
                $t .= '</div>';
                return $t;
            });

        echo $dt->json();
    }
}
