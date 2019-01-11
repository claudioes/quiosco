<?php

namespace App\Controllers;

define("FOLDER_PROVEEDOR", FOLDER_FILES . 'proveedor');

use \Exception;
use \DateTime;
use Upload;
use Helper;
use App\Helpers\Settings;
use App\Helpers\Datatable;

class Proveedor extends Controller
{
    private function createOrEdit($id=0)
    {
        $db = $this->db;

        $proveedor = null;
        if ($id) {
            $proveedor = $db->proveedor[$id];
            if (!$proveedor) {
                throw new Exception("El proveedor ID $id no existe.");
            }
        }

        $this->render('/proveedor/form.twig', [
            'proveedor' => $proveedor,
        ]);
    }

    public function index()
    {
        $this->render('/proveedor/index.twig');
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
            'codigo' => $post['codigo'],
            'nombre' => $post['nombre'],
            'razon' => $post['razon'],
            'domicilio' => $post['domicilio'],
            'localidad' => $post['localidad'],
            'cp' => $post['cp'],
            'telefono' => $post['telefono'],
            'email' => $post['email'],
            'cuit' => $post['cuit'],
            'notas' => $post['notas']
        ];

        try {
            if ($id === 0) {
                $proveedor = $db->proveedor->insert($values);
            } else {
                $proveedor = $db->proveedor[$id];
                $proveedor->update($values);
            }
        } catch (Exception $e) {
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        $this->app->flash('success', "Los datos del proveedor '$values[nombre]' fueron actualizados");
        $this->responseJson([
            'success' => true
        ]);
    }

    public function delete($id)
    {
        $db = $this->db;
        $proveedor = $db->proveedor[$id];

        try {
            if ($proveedor) {
                $proveedor->delete();
                $this->responseJson([
                    'success' => true
                ]);
            } else {
                throw new Exception("No se encontró el proveedor con ID $id");
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
        $dt = new Datatable(Settings::get('db'), 'proveedor', 'id');
        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
            ->addColumn('id')
            ->addColumn('codigo')
            ->addColumn('nombre', null, function ($d, $row) use ($app) {
                return '<a href="' . $app->urlFor('Proveedor:edit', ['id' => $row['id']]) . '">' . $d . '</a>';
            })
            ->addColumn('razon')
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

    public function find($id)
    {
        $db = $this->db;
        $request = $this->request;
        $proveedor = $db->proveedor[$id];

        if ($proveedor) {
            $this->responseJson([
                'success' => true,
                'data' => $proveedor,
            ]);
        } else {
            $this->responseJson([
                'success' => false,
                'message' => "No se encontró el proveedor con ID $id",
            ]);
        }
    }

    public function documento($proveedorId)
    {
        $db = $this->db;
        $documentos = $db->proveedor_documento('proveedor_id', (int) $proveedorId)->order('fecha DESC');
        $this->render('proveedor/documento-table.twig', [
            'documentos' => $documentos,
        ]);
    }

    public function saveDocumento()
    {
        $db = $this->db;
        $request = $this->request;
        $proveedorId = (int) $request->post('documento-proveedor-id');

        if (!$proveedorId) {
            $this->responseJson([
                'success' => false,
                'message' => "No se definió el proveedor",
            ]);
            return;
        }

        $fecha = DateTime::createFromFormat('d/m/Y', $request->post('documento-fecha'));
        if (!$fecha) {
            $this->responseJson([
                'success' => false,
                'message' => "La fecha es incorrecta",
            ]);
            return;
        }

        $aumento = (float) $request->post('documento-aumento');

        if (isset($_FILES['documento-archivo'])) {
            $upload = new Upload(FOLDER_PROVEEDOR);
            $upload->file($_FILES['documento-archivo']);
            /*
            $upload->set_allowed_mime_types([
                'application/pdf',
                'text/plain',
                'application/excel',
                'application/msword',
                'application/zip',
                'application/msword',
                'image/jpeg',
                'image/png',
                'image/bmp',
            ]);
            */
            
            $result = $upload->upload();

            if (!$result['status']) {
                $this->responseJson([
                    'success' => false,
                    'message' => implode('<br>', $result['errors']),
                ]);
                return;
            }
        } else {
            $this->responseJson([
                'success' => false,
                'message' => "No se ingresó ningun archivo"
            ]);
            return;
        }

        $values = [
            'id' => $result['filename'],
            'proveedor_id' => $proveedorId,
            'fecha' => $fecha,
            'aumento' => $aumento,
            'nombre' => $result['original_filename'],
        ];

        try {
            $db->proveedor_documento->insert($values);
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

    public function downloadDocumento($id)
    {
        $db = $this->db;
        $documento = $db->proveedor_documento[$id];

        if ($documento) {
            $file = FOLDER_PROVEEDOR . DS . $id;
            $fileName = $documento['nombre'];
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'. urlencode($fileName) .'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
            }
        }
    }

    public function deleteDocumento($id)
    {
        $db = $this->db;
        $documento = $db->proveedor_documento[$id];
        if ($documento) {
            $file = FOLDER_PROVEEDOR . DS . $id;

            try {
                if (file_exists($file)) {
                    unlink($file);
                }

                $documento->delete();
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
    }
}
