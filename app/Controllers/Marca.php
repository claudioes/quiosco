<?php

namespace App\Controllers;

use App\Helpers\Datatable;
use App\Helpers\Settings;
use App\Helpers\Helper;
use \Exception;

class Marca extends Controller
{
    private function createOrEdit($id=0)
    {
        $db = $this->db;

        $marca = null;
        $articulos = null;

        if ($id) {
            $marca = $db->marca[$id];

            if ($marca) {
                $articulos = $db->articulo('marca_id', $id);
            } else {
                throw new Exception("La marca ID $id no existe.");
            }
        }

        $this->render('/marca/form.twig', [
            'marca' => $marca,
            'articulos' => $articulos
        ]);
    }

    public function index()
    {
        $this->render('/marca/index.twig');
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
                $marca = $db->marca->insert($values);
            } else {
                $marca = $db->marca[$id];
                $marca->update($values);
            }

            $this->app->flash('success', 'Los datos de la marca \'' . $values['nombre'] . '\' fueron actualizados');
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
        $marca = $db->marca[$id];

        try {
            if ($marca) {
                $marca->delete();
                $this->responseJson([
                    'success' => true
                ]);
            } else {
                throw new Exception("No se encontró la marca con ID $id");
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
        $dt = new Datatable(Settings::get('db'), 'marca', 'id');
        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
        ->addColumn('id')
        ->addColumn('orden')
        ->addColumn('nombre', null, function ($d, $row) use ($app) {
            return '<a href="' . $app->urlFor('Marca:edit', ['id' => $row['id']]) . '">' . $d . '</a>';
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
