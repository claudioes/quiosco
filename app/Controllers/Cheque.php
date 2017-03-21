<?php
namespace App\Controllers;

use App\Helpers\Datatable;
use App\Helpers\Settings;
use App\Helpers\Helper;
use \Exception;
use \DateTime;

class Cheque extends Controller
{
    private function createOrEdit($id=0)
    {
        $db = $this->db;

        $cheque = null;
        $articulos = null;

        if ($id) {
            $cheque = $db->cheque[$id];

            if ($cheque) {
                $articulos = $db->articulo('cheque_id', $id);
            } else {
                throw new Exception("El cheque ID $id no existe.");
            }
        }

        $bancos = $db->banco->fetchPairs('id', 'nombre');
        $clientes = $db->banco->fetchPairs('id', 'nombre');
        $proveedores = $db->banco->fetchPairs('id', 'nombre');
        $estados = [
            'C' => 'Cartera',
            'D' => 'Depositado',
            'E' => 'Entregado',
            'R' => 'Rechazado'
        ];

        $this->render('/cheque/form.twig', [
            'cheque' => $cheque,
            'articulos' => $articulos,
            'bancos' => $bancos,
            'clientes' => $clientes,
            'proveedores' => $proveedores,
            'estados' => $estados,
        ]);
    }

    public function index()
    {
        $this->render('/cheque/index.twig');
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
        $id = (int)$this->request->post('id');

        $values = [
            'numero' => (int)$post['numero'],
            'banco_id' => (int)$post['banco'],
            'cuit' => $post['cuit'],
            'fecha' => DateTime::createFromFormat('d/m/Y', $post['fecha']),
            'importe' => (float)$post['importe'],
            'estado' => strtoupper($post['estado']),
        ];

        try {
            if ($id === 0) {
                $cheque = $db->cheque->insert($values);
            } else {
                $cheque = $db->cheque[$id];
                $cheque->update($values);
            }

            $this->app->flash('success', 'Los datos de el cheque nº \'' . $values['numero'] . '\' fueron actualizados');
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
        $db = $this->db;
        $cheque = $db->cheque[$id];

        try {
            if ($cheque) {
                if ($cheque['recibo_id']) {
                    throw new Exception("No se puede eliminar el cheque porque está asociado a un recibo");
                }

                $cheque->delete();
                $this->responseJson([
                    'success' => true
                ]);
            } else {
                throw new Exception("No se encontró el cheque con ID $id");
            }
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
        $dt = new Datatable(Settings::get('db'), 'v_cheque', 'id');
        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
            ->addColumn('id')
            ->addColumn('numero', null, function ($d, $row) use ($app) {
                return '<a href="' . $app->urlFor('Cheque:edit', ['id' => $row['id']]) . '">' . $d . '</a>';
            })
            ->addColumn('banco_nombre')
            ->addColumn('cuit')
            ->addColumn('fecha', null, function ($d, $row) {
                return date('d/m/Y', strtotime($d));
            })
            ->addColumn('importe', null, function ($d, $row) {
                return number_format((float)$d, 2, ',', '.');
            })
            ->addColumn('vencimiento_dias')
            ->addColumn('vencimiento', null, function ($d, $row) {
                $title = date('d/m/Y', strtotime($d));
                $dias = (int)$row['vencimiento_dias'];

                if ($dias === 0) {
                    $title .= ' <br><span class="label label-danger">Vence <strong>HOY</strong></span>';
                } elseif ($dias < 0) {
                    $title .= ' <br><span class="label label-danger"><strong>Vencido</strong></span>';
                } elseif ($dias < 5) {
                    $title .= ' <br><span class="label label-warning">Vence en ' . $dias . ' dia(s)</span>';
                }

                return $title;
            })
            ->addColumn('estado', null, function ($d, $row) {
                switch (strtolower($d)) {
                    case 'c': return 'Cartera';
                    case 'd': return 'Depositado';
                    case 'e': return 'Entregado';
                    case 'r': return 'Rechazado';
                }
            })
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

        echo $dt->json();
    }
}
