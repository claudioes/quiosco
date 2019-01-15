<?php
namespace App\Controllers;

use mikehaertl\wkhtmlto\Pdf;
use \Exception;
use App\Models\Articulo;
use App\Helpers\Settings;
use App\Helpers\Helper;
use App\Helpers\Deposito;
use App\Helpers\Datatable;

class Presupuesto extends Controller
{
    public function index()
    {
        $clientes = $this->db
            ->cliente
            ->select('id, codigo, nombre')
            ->order('nombre');

        $this->render('presupuesto/index.twig', [
            'clientes' => $clientes,
        ]);
    }

    public function create()
    {
        $db = $this->db;
        $app = $this->app;
        $request = $this->request;

        $cliente = null;
        $detalle = [];

        // Cliente
        $clienteId = (int) $request->get('clienteId');
        if ($clienteId) {
            $cliente = $db->cliente->select('id, codigo, nombre')[$clienteId];
            if (!$cliente) {
                $app->flash('error', "No se encontró el cliente con ID $clienteId");
                $app->redirect($app->urlFor('Presupuesto:index'));
            }
        }

        // Pedido
        $pedidoId = (int) $request->get('pedidoId');
        if ($pedidoId) {
            $pedido = $db->pedido->where('id', $pedidoId);

            if ($clienteId) {
                $pedido->and('cliente_id', $clienteId);
            }

            if ($pedido->count('*') == 0) {
                // El pedido no existe
                $mensaje = "No se encontró el pedido Nº $pedidoId";

                if ($cliente) {
                    $mensaje .= ' del cliente ' . $cliente['nombre'];
                }

                $app->flash('error', $mensaje);
                $app->redirect($app->urlFor('Presupuesto:index'));
            } else {
                // El pedido existe, compruebo que no esté facturado
                $pedido = $pedido->fetch();
                if ($pedido['facturado']) {
                    $app->flash('error', "El pedido Nº $pedidoId ya fue facturado");
                    $app->redirect($app->urlFor('Presupuesto:index'));
                }

                // Si no se seleccionó un cliente, cargo el del pedido
                if ($clienteId === 0) {
                    $clienteId = (int) $pedido['cliente_id'];
                    $cliente = $db->cliente->select('id, codigo, nombre')[$clienteId];
                }

                // Detalle
                $pedidoDetalle = $db
                    ->pedido_detalle
                    ->select(
                        'pedido_detalle.articulo_id',
                        'articulo.codigo',
                        'articulo.descripcion',
                        'articulo.precio',
                        'pedido_detalle.cantidad')
                    ->where('pedido_detalle.pedido_id', $pedidoId);

                $articulo = new Articulo($this->pdo);

                foreach ($pedidoDetalle as $item) {
                    $articuloId = (int)$item['articulo_id'];
                    $cantidad = (float)$item['cantidad'];

                    $detalle[] = [
                        'articulo_id' => $articuloId,
                        'codigo' => $item['codigo'],
                        'descripcion' => $item['descripcion'],
                        'cantidad' => $cantidad,
                        'precio' => (float)$item['precio'],
                    ];
                }
            }
        }

        $clientes = $db
            ->cliente
            ->select('id, codigo, nombre')
            ->order('nombre');

        $this->render('presupuesto/form.twig', [
            'clientes' => $clientes,
            'cliente' => $cliente,
            'pedidoId' => $pedidoId,
            'detalle' => $detalle,
        ]);
    }

    public function save()
    {
        $db = $this->db;
        $request = $this->request;

        try {
            if ($request->post('pedido-id')) {
                $pedidoId = (int)$request->post('pedido-id');
            } else {
                $pedidoId = null;
            }

            $clienteId = (int) $request->post('cliente');
            //$saldo = (float) $request->post('saldo');

            if ($clienteId === 0) {
                throw new Exception('No se seleccionó ningún cliente');
            } else {
                $cliente = $db
                    ->cliente
                    ->select('cliente.*, v_cliente_saldo:saldo')
                    ->where('cliente.id = ?', $clienteId)
                    ->fetch();

                if (!$cliente) {
                    throw new Exception("El cliente con ID $clienteId no existe");
                } else {
                    // Saldo actualizado de la cuenta corriente
                    $saldo = (float)$cliente['saldo'];
                }
            }

            $notas = trim($request->post('notas'));
            $detalleArticuloId = $request->post('detalle-articulo-id');
            $detalleTipo = $request->post('detalle-tipo');
            $detalleCodigo = $request->post('detalle-codigo');
            $detalleDescripcion = $request->post('detalle-descripcion');
            $detalleCantidad = $request->post('detalle-cantidad');
            $detallePrecio = $request->post('detalle-precio');
            $detalleDescuento = $request->post('detalle-descuento');
            
            if (!$detalleArticuloId || count($detalleArticuloId) === 0) {
                throw new Exception('No se ingresaron artículos al detalle');
            }

            # Detalle y cálculo de importes

            $items = [];
            $faltaStock = [];
            $total = 0;
            $ruleArticulo = new Articulo($this->pdo);
            $errores = [];

            foreach ($detalleArticuloId as $i => $articuloId) {
                $item = [
                    'tipo'          => $detalleTipo[$i],
                    'articulo_id'   => (int) $articuloId,
                    'codigo'        => $detalleCodigo[$i],
                    'descripcion'   => $detalleDescripcion[$i],
                    'cantidad'      => (int) $detalleCantidad[$i],
                    'precio'        => (float) $detallePrecio[$i],
                    'descuento'     => (float) $detalleDescuento[$i],
                    'stock'         => $ruleArticulo->stock($articuloId, Deposito::DISTRIBUIDORA),
                ];

                if ($item['cantidad'] === 0) {
                    $errores[] = "La cantidad del artículo $item[codigo] debe ser mayor a 0 (cero)";
                } elseif ($item['cantidad'] > $item['stock']) {
                    $errores[] = "No hay suficiente stock del artículo $item[codigo] (Stock: $item[stock])";
                } else {
                    $precio = round($item['precio'], 2);
                    $precioNeto = round($precio * (1 - $item['descuento'] / 100), 2);
                    $importe = $item['cantidad'] * $precioNeto;
                    
                    $total += $importe;
                    
                    $item['importe'] = $importe;
                    $items[] = $item;
                }
            }

            if ($errores) {
                throw new Exception('<ul><li>' . implode('</li><li>', $errores) . '</li></ul>');
            }

            if ($total == 0) {
                throw new Exception('El total del presupuesto no puede ser 0 (cero)');
            }

            $db->transaction = 'BEGIN';

            try {
                # Cabecera del presupuesto
                $presupuesto = $db->presupuesto()->insert([
                    'cliente_id'        => $clienteId,
                    'fecha'             => new \NotORM_Literal("NOW()"),
                    'total'             => $total,
                    'cliente_saldo'     => $saldo,
                    'pedido_id'         => $pedidoId,
                    'notas'             => $notas,
                ]);

                if ($pedidoId) {
                    $pedido = $db->pedido('id', $pedidoId)->update([
                        'facturado' => true
                    ]);
                }

                $presupuestoId = $presupuesto['id'];
                $concepto = "Presupuesto Nº $presupuestoId";

                # Items del presupuesto
                foreach ($items as $item) {
                    $articuloId = $item['articulo_id'];
                    $costo = $db->articulo[$articuloId]['costo'];
                    
                    # Movimiento de stock

                    if ($item['cantidad'] > 0) {
                        // En presupuestos se descuenta del deposito "Distribuidora"
                        $db->stock_movimiento->insert([
                            'fecha'         => new \NotORM_Literal('NOW()'),
                            'descripcion'   => $concepto,
                            'articulo_id'   => $articuloId,
                            'deposito_id'   => Deposito::DISTRIBUIDORA,
                            'cantidad'      => $item['cantidad'],
                            'costo'         => $costo,
                            'precio'        => $item['precio'],
                            'tipo'          => 'S',
                            'usuario_id'    => $this->usuario->id,
                        ]);
                    }

                    # Detalle del presupuesto

                    $db->presupuesto_detalle->insert([
                        'presupuesto_id'    => $presupuestoId,
                        'articulo_id'       => $articuloId,
                        'codigo'            => $item['codigo'],
                        'descripcion'       => $item['descripcion'],
                        'costo'             => $costo,
                        'precio'            => $item['precio'],
                        'cantidad'          => $item['cantidad'],
                        'descuento'         => $item['descuento'],
                    ]);
                }

                // Cuenta corriente del cliente
                // El importe puede ser negativo por una devolución

                $debe = 0;
                $haber = 0;
                if ($total >= 0) {
                    $debe = $total;
                } else {
                    $haber = abs($total);
                }

                $db->cliente_cc->insert([
                    'cliente_id'        => $clienteId,
                    'fecha'             => new \NotORM_Literal('NOW()'),
                    'concepto'          => $concepto,
                    'debe'              => $debe,
                    'haber'             => $haber,
                    'presupuesto_id'    => $presupuestoId
                ]);

                $db->transaction = 'COMMIT';
            } catch (Exception $e) {
                $db->transaction = 'ROLLBACK';
                throw $e;
            }

            $this->app->flash('success', 'Los datos del presupuesto Nº ' . $presupuestoId . ' fueron actualizados');
            $this->responseJson([
                'success' => true,
                'id' => $presupuestoId
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
        try {
            $presupuesto = $db->presupuesto[$id];

            if ($presupuesto === null) {
                throw new Exception("El presupuesto con ID $id no existe");
            } else {
                $db->transaction = 'BEGIN';
                try {
                    # Marco el presupuesto como anulado
                    $presupuesto->update([
                        'anulado' => true
                    ]);

                    # Devuelvo el stock
                    $items = $presupuesto->presupuesto_detalle();
                    foreach ($items as $item) {
                        $db->stock_movimiento->insert([
                            'fecha'         => new \NotORM_Literal('NOW()'),
                            'descripcion'   => "Anulación de presupuesto Nº $id",
                            'articulo_id'   => $item['articulo_id'],
                            'deposito_id'   => 1, # Distribuidora
                            'cantidad'      => $item['cantidad'],
                            'costo'         => $item['costo'],
                            'precio'        => $item['precio'],
                            'tipo'          => 'E',
                            'usuario_id'    => $this->usuario->id,
                        ]);
                    }

                    # Anulo la imputación en cuenta corriente
                    $presupuesto->cliente_cc()->delete();

                    # Desvinculo el pedido
                    if ($presupuesto['pedido_id']) {
                        $pedido = $db->pedido[(int)$presupuesto['pedido_id']];
                        $pedido->update([
                            'facturado' => false,
                        ]);
                    }

                    $db->transaction = 'COMMIT';
                } catch (Exception $e) {
                    $db->transaction = 'ROLLBACK';
                    throw $e;
                }
            }

            $this->responseJson([
                'success' => true,
            ]);
        } catch (Exception $e) {
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

        $where = '';
        if (!$this->usuario->esAdministrador) {
            $where = 'cliente_categoria_id=' . $this->usuario->clienteCategoriaId;
        }

        $app = $this->app;
        $dt = new Datatable(Settings::get('db'), 'v_presupuesto', 'id', $where);
        $dt
            ->addColumn('id', 'DT_RowId', function ($d, $row) {
                return 'row_' . $d;
            })
            ->addColumn('id')
            ->addColumn('fecha', null, function ($d, $row) {
                return date('d/m/y', strtotime($d));
            })
            ->addColumn('cliente_id')
            ->addColumn('cliente_nombre')
            ->addColumn('pedido_id')
            ->addColumn('total', null, function ($d, $row) {
                return '$' . number_format((float) $d, 2, ',', '.');
            })
            ->addColumn('anulado')
            ->addColumn('id', 'accion', function ($d, $row) use ($app) {
                $t  = '<div class="btn-group" role="group" style="display: flex;">';
                $t .=   '<a class="btn btn-default" href="' .  $app->urlFor('Presupuesto:printPage', ['id' => $d]) . '" target="_blank">Imprimir</a>';
                $t .=   '<div class="btn-group pull-right" role="group">';
                $t .=     '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
                $t .=       '<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>';
                $t .=     '</button>';
                $t .=     '<ul class="dropdown-menu">';
                $t .=       '<li><a href="#" data-id="' . $d . '" class="delete"><i class="glyphicon glyphicon-remove"></i> Anular</a></li>';
                $t .=     '</ul>';
                $t .=   '</div>';
                $t .= '</div>';
                return $t;
            });

        echo $dt->json();
    }

    public function printPage($id)
    {
        if (!$this->usuario->esAdministrador) {
            $cliente = $this->db->presupuesto[(int)$id]->cliente;
            if ($cliente['cliente_categoria_id'] != $this->usuario->clienteCategoriaId) {
                throw new Exception("No se encontró el presupuesto con ID $id");
            }
        }

        if (!file_exists(FOLDER_PRESUPUESTO)) {
            mkdir(FOLDER_PRESUPUESTO, 0777, true);
        }

        $fileName = FOLDER_PRESUPUESTO . DS . "Presupuesto_$id.pdf";
        if (!file_exists($fileName)) {
            $sth = $this->pdo
                ->prepare("SELECT * FROM v_presupuesto p WHERE p.id = ?");
            $sth->execute([$id]);
            $presupuesto = $sth->fetch();

            $sth = $this->pdo
                ->prepare("SELECT * FROM v_presupuesto_detalle d WHERE d.presupuesto_id = ?");
            $sth->execute([$id]);
            $detalle = $sth->fetchAll();

            $html = $this->app->view->render('presupuesto/print.twig', [
                'presupuesto' => $presupuesto,
                'detalle' => $detalle
            ]);

            $pdf = new Pdf([
                'commandOptions' => [
                    'useExec' => true,
                ],
                'encoding'      => 'UTF-8',
                'no-outline',   // Make Chrome not complain
                'page-size'     => 'A4',
                'orientation'   => 'Landscape',
                'margin-top'    => 4,
                'margin-right'  => 4,
                'margin-bottom' => 4,
                'margin-left'   => 4,
                'disable-smart-shrinking',
                'zoom'          => WKHTMLTOPDF_ZOOM - 0.1, // Un poco mas chico que lo normal
            ]);

            $pdf->addPage($html);
            if (!$pdf->saveAs($fileName)) {
                throw new Exception($pdf->getError());
            }
        }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Type: application/pdf");
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($fileName));
        header('Content-Disposition: inline; filename=' . urlencode(basename($fileName)));
        ob_clean();
        flush();
        readfile($fileName);
    }
}
