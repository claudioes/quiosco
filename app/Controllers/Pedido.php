<?php
namespace App\Controllers;

use App\Helpers\Datatable;
use App\Helpers\Settings;
use App\Helpers\Helper;
use \Exception;
use mikehaertl\wkhtmlto\Pdf;

define("FOLDER_PEDIDO", FOLDER_FILES . 'pedido');

class Pedido extends Controller
{
    public function index()
    {
        $this->render('pedido/index.twig');
    }

    public function create()
    {
        $db = $this->db;

        $this->render('pedido/form.twig', [
            'clientes' => $db->cliente->order('nombre')
        ]);
    }

    public function save()
    {
        $db = $this->db;
        $request = $this->request;

        try {
            $clienteId = (int) $request->post('cliente');

            if ($clienteId === 0) {
                throw new Exception('No se seleccionó ningún cliente');
            } else {
                $cliente = $db->cliente[$clienteId];
                if ($cliente === null) {
                    throw new Exception("El cliente con ID $clienteId no existe");
                }
            }

            $detalleArticuloId = $request->post('detalle-articulo-id');
            $detalleCantidad = $request->post('detalle-cantidad');

            if (!$detalleArticuloId || count($detalleArticuloId) === 0) {
                throw new Exception('No se ingresaron artículos al detalle');
            }

            $db->transaction = 'BEGIN';

            try {
                # Cabecera del pedido
                $pedido = $db->pedido()->insert([
                    'cliente_id'        => $clienteId,
                    'fecha'             => new \NotORM_Literal("NOW()"),
                ]);

                $pedidoId = $pedido['id'];

                # Detalle del pedido
                foreach ($detalleArticuloId as $i => $articuloId) {
                    $db->pedido_detalle->insert([
                        'pedido_id' => $pedidoId,
                        'articulo_id' => (int) $articuloId,
                        'cantidad' => (int) $detalleCantidad[$i]
                    ]);
                }

                $db->transaction = 'COMMIT';
            } catch (Exception $e) {
                $db->transaction = 'ROLLBACK';
                throw $e;
            }
        } catch (\Exception $e) {
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        $this->app->flash('success', 'Los datos del pedido Nº ' . $pedidoId . ' fueron actualizados');
        $this->responseJson([
            'success' => true,
            'id' => $pedidoId
        ]);
    }

    public function delete($id)
    {
        $db = $this->db;
        try {
            $pedido = $db->pedido[$id];

            if ($pedido === null) {
                throw new Exception("No se encontró el pedido con ID $id");
            } else {
                $pedido->delete();
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
        $app = $this->app;

        $dt = new Datatable(Settings::get('db'), 'v_pedido', 'id');
        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
            ->addColumn('id')
            ->addColumn('fecha', null, function ($d, $row) {
                return date('d/m/y', strtotime($d));
            })
            ->addColumn('cliente_id')
            ->addColumn('cliente_nombre')
            ->addColumn('facturado')
            ->addColumn('id', 'accion', function ($d, $row) use ($app) {
                $t  = '<div class="btn-group pull-right" role="group" style="display: flex;">';

                if (!$row['facturado']) {
                    $t .= '<a class="btn btn-success" href="'. $app->urlFor('Presupuesto:create') . '?pedidoId=' . $d . '" class="presupuesto">Presupuestar</a>';
                }

                $t .=   '<a class="btn btn-default" href="' .  $app->urlFor('Pedido:printPage', ['id' => $d]) . '" target="_blank">Imprimir</a>';
                $t .=   '<div class="btn-group pull-right" role="group">';
                $t .=     '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
                $t .=       '<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>';
                $t .=     '</button>';
                $t .=     '<ul class="dropdown-menu">';
                $t .=       '<li><a href="#" data-id="' . $d . '" class="delete"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>';
                $t .=     '</ul>';
                $t .=   '</div>';
                $t .= '</div>';

                return $t;
            });

        echo $dt->json();
    }

    public function printPage($id)
    {
        $db = $this->db;
        $pedido = $db->pedido[$id];
        $detalle = $db->pedido_detalle('pedido_id', $id);

        $html = $this->app->view->render('pedido/print.twig', [
            'pedido' => $pedido,
            'detalle' => $detalle
        ]);

        $pdf = new Pdf([
            'commandOptions' => [
                'useExec' => true,
            ],
            'encoding'      => 'UTF-8',
            'no-outline',   // Make Chrome not complain
            'page-size'     => 'A4',
            'orientation'   => 'Portrait',
            'margin-top'    => 4,
            'margin-right'  => 4,
            'margin-bottom' => 4,
            'margin-left'   => 4,
            'disable-smart-shrinking',
            'zoom'          => WKHTMLTOPDF_ZOOM // Soluciona problemas con el tamaño de letra en servidores Linux
        ]);

        $pdf->addPage($html);

        if (!file_exists(FOLDER_PEDIDO)) {
            mkdir(FOLDER_PEDIDO, 0777, true);
        }

        $fileName = FOLDER_PEDIDO . DS . "Pedido_$id.pdf";
        if (!file_exists($fileName)) {
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

    public function articulos()
    {
        $this->render('pedido/articulos.twig');
    }
}
