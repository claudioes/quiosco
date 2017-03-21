<?php

namespace App\Controllers;

use App\Helpers\Datatable;
use App\Helpers\Settings;
use App\Helpers\Helper;
use \Exception;

class Cobrador extends Controller
{
    private function createOrEdit($id=0)
    {
        $db = $this->db;

        $cobrador = null;

        if ($id) {
            $cobrador = $db->cobrador[$id];
            if (!$cobrador) {
                throw new Exception("No se encontró el cobrador con ID $id");
            }
        }

        $this->render('/cobrador/form.twig', [
            'cobrador' => $cobrador,
        ]);
    }

    public function index()
    {
        $this->render('/cobrador/index.twig');
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

        $values = [
            'nombre' => $post['nombre'],
        ];

        try {
            if ($id === 0) {
                $cobrador = $db->cobrador->insert($values);
            } else {
                $cobrador = $db->cobrador[$id];
                $cobrador->update($values);
            }

            $this->app->flash('success', 'Los datos del cobrador \'' . $values['nombre'] . '\' fueron actualizados');
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
        $cobrador = $db->cobrador[$id];

        try {
            if ($cobrador) {
                $cobrador->delete();
                $this->responseJson([
                    'success' => true
                ]);
            } else {
                throw new Exception("No se encontró el cobrador con ID $id");
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
        $dt = new Datatable(Settings::get('db'), 'cobrador', 'id');
        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
            ->addColumn('id')
            ->addColumn('nombre', null, function ($d, $row) use ($app) {
                return '<a href="' . $app->urlFor('Cobrador:edit', ['id' => $row['id']]) . '">' . $d . '</a>';
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
