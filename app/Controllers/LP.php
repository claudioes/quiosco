<?php
namespace App\Controllers;

use App\Helpers\Settings;
use App\Helpers\Datatable;

class LP extends Controller
{
    private function createOrEdit($id = null)
    {
        $db = $this->db;

        $grupos = $db->grupo->fetchPairs('id', 'nombre');
        $familias = $db->familia->fetchPairs('id', 'nombre');
        $marcas = $db->marca->fetchPairs('id', 'nombre');
        $modelos = $db->lp_modelo->fetchPairs('id', 'descripcion');

        $lp = null;
        if ($id) {
            $lp = $db->lp[(int)$id];
        }

        $sth = $this->pdo->prepare("
            SELECT
                a.id,
                a.codigo,
                a.descripcion,
                a.precio,
                f.nombre AS familia,
                m.nombre AS marca,
                CASE WHEN d.id IS NULL THEN 0 ELSE 1 END AS seleccionado
            FROM
                articulo a
            JOIN
                familia f ON a.familia_id = f.id
            JOIN
                marca m ON a.marca_id = m.id
            LEFT JOIN
                lp_articulo d ON a.id = d.articulo_id AND d.lp_id = ?
            ORDER BY
                a.codigo
        ");

        $sth->execute([(int)$id]);
        $articulos = $sth->fetchAll(\PDO::FETCH_ASSOC);

        $this->render('lp/form.twig', [
            'lp' => $lp,
            'grupos' => $grupos,
            'marcas' => $marcas,
            'familias' => $familias,
            'articulos' => $articulos,
            'modelos' => $modelos,
        ]);
    }

    public function index()
    {
        $this->render('/lp/index.twig');
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
        $request = $this->request;
        $db = $this->db;
        $id = (int)$request->post('id');
        $descripcion = trim($request->post('descripcion'));
        $articulos = (array)$request->post('articuloid');

        if ($descripcion) {
            $existe = $db->lp('descripcion', $descripcion)->fetch();

            if ($existe && (int)$existe['id'] !== $id) {
                $this->responseJson([
                    'success' => false,
                    'message' => "Ya existe una plantilla con la descripción '$descripcion'",
                ]);
                $this->app->stop();
            }
        } else {
            $this->responseJson([
                'success' => false,
                'message' => "Debe ingresar una descripción",
            ]);
            $this->app->stop();
        }

        $values = [
            'descripcion' => $descripcion,
            'grupo_id' => (int)$request->post('grupo'),
            'lp_modelo_id' => (int)$request->post('modelo'),
        ];

        $db->transaction = 'BEGIN';
        try {
            if ($id) {
                $lp = $db->lp[$id];
                $lp->update($values);
            } else {
                $lp = $db->lp->insert($values);
            }

            $lp->lp_articulo()->delete();

            foreach ($articulos as $ar) {
                $db->lp_articulo->insert([
                    'lp_id' => $lp['id'],
                    'articulo_id' => $ar,
                ]);
            }

            $db->transaction = 'COMMIT';

            $this->app->flash('success', "Los datos fueron guardados");
            $this->responseJson([
                'success' => true,
                'id' => $lp['id'],
                'redirect' => $this->app->urlFor('LP:index'),
            ]);
        } catch (\Exception $e) {
            $db->transaction = 'ROLLBACK';

            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        $db = $this->db;
        $lp = $db->lp[$id];

        try {
            if ($lp) {
                $lp->delete();
                $this->responseJson([
                    'success' => true
                ]);
            } else {
                throw new \Exception("No se encontró la lista de precios con ID $id");
            }
        } catch (\Exception $e) {
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
        $dt = new Datatable(Settings::get('db'), 'v_lp', 'id');
        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
            ->addColumn('id')
            ->addColumn('grupo_nombre')
            ->addColumn('generados')
            ->addColumn('ultimo_numero')
            ->addColumn('descripcion', null, function ($d, $row) use ($app) {
                return '<a href="'. $app->urlFor('LP:edit', ['id' => $row['id']]) .'">' . $d . '</a>';
            })
            ->addColumn('id', 'accion', function ($d, $row) use ($app) {
                $t = '';

                if ((int)$row['generados']) {
                    $t .= '<a class="btn btn-default generados" href="' . $app->urlFor('LP:generados', ['id' => $d]) . '">Generados <span class="badge">' . $row['generados'] . '</span></a>';
                }

                $t .= '<div class="btn-group pull-right">';
                $t .=   '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">';
                $t .=     '<i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>';
                $t .=   '</button>';
                $t .=   '<ul class="dropdown-menu">';
                $t .=     '<li><a href="' . $app->urlFor('LP:generar', ['id' => $d]) . '" class="generar"><i class="glyphicon glyphicon-flash"></i> Generar</a></li>';
                $t .=     '<li role="separator" class="divider"></li>';
                $t .=     '<li><a href="#" data-id="' . $d . '" class="delete"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>';
                $t .=   '</ul>';
                $t .= '</div>';

                return '<div class="btn-group" role="group" style="display: flex;">' . $t . '</div>';
            });

        echo $dt->json();
    }

    public function generados($id)
    {
        $db = $this->db;
        $lp = $db->lp[$id];
        $generados = $lp->lp_generado()
            ->order('fecha DESC, numero DESC')
            ->limit(100);

        $this->render('lp/generados.twig', [
            'lp' => $lp,
            'generados' => $generados,
        ]);
    }

    public function generar($id = null)
    {
        $app = $this->app;
        $request = $app->request;
        $db = $this->db;

        if ($request->isGet()) {
            if ($id) {
                // Generar una sola lista
                $lp = $db->lp[(int)$id];
                $modelos = $db->lp_modelo->fetchPairs('id', 'descripcion');

                $this->render('lp/generar.twig', [
                    'lp' => $lp,
                    'modelos' => $modelos,
                ]);
            } else {
                // Generar todas las listas
                $this->render('lp/generar_todos.twig');
            }
        } else {
            // Verifico que las carpeta de destino exista
            if (!file_exists(FOLDER_LP) && !mkdir(FOLDER_LP, 0777, true)) {
                $this->responseJson([
                    'success' => false,
                    'error' => 'No se pudo crear la carpeta ' . FOLDER_LP,
                ]);
                $this->app->stop();
            }

            // Verifico que la fecha sea correcta
            $fecha = \DateTime::createFromFormat('d/m/Y', $request->post('fecha'));
            if (!$fecha) {
                $this->responseJson([
                    'success' => false,
                    'error' => 'La fecha es incorrecta',
                ]);
                $this->app->stop();
            }

            $numero = (int)$request->post('numero');
            $cambios = trim($request->post('cambios'));
            $elModeloId = 0;

            if ($id) {
                // Generar una sola lista
                $elModeloId = (int)$request->post('modelo-id');
                $listas = $db->lp('id', $id);
            } else {
                // Generar todas las listas
                $listas = $db->lp;
            }

            $resultado = [];
            foreach ($listas as $l) {
                // Id
                $lpId = (int)$l['id'];

                // Recargo
                $grupo = $l->grupo;
                $recargo = (float)$grupo['recargo'];

                //Modelo
                $modeloId = $elModeloId ?: (int)$l['lp_modelo_id'];

                // Articulos
                $sth = $this->pdo->prepare("
                    SELECT
                        a.codigo,
                        a.descripcion,
                        a.precio,
                        a.familia_id,
                        f.nombre AS familia_nombre,
                        a.marca_id,
                        m.nombre AS marca_nombre
                    FROM
                        articulo a
                    JOIN
                        familia f ON a.familia_id = f.id
                    JOIN
                        marca m ON a.marca_id = m.id
                    JOIN
                        lp_articulo d ON d.articulo_id = a.id
                    WHERE
                        d.lp_id = ?
                    ORDER BY
                        f.orden, m.orden, a.codigo
                ");
                $sth->execute([$lpId]);
                $articulos = $sth->fetchAll(\PDO::FETCH_ASSOC);

                // Nombre del archivo
                $filename = preg_replace("/[^a-z0-9\.]/", "", strtolower($grupo['nombre']));
                $filename = "lista_" . $filename . "_" . $numero . "_" . date('YmdHis') . ".xlsx";

                $export = new \App\Helper\LP_Export\Excel();
                $export->templateExcel = FOLDER_LP . 'modelo' . DS . $modeloId . '.xlsx';
                $export->numero = $numero;
                $export->fecha = $fecha;
                $export->recargo = $recargo;
                $export->articulos = $articulos;

                if ($export->save(FOLDER_LP . $filename)) {
                    try {
                        $generado = $db->lp_generado->insert([
                            'lp_id'     => $lpId,
                            'creado'    => new \NotORM_Literal('NOW()'),
                            'fecha'     => $fecha,
                            'numero'    => $numero,
                            'cambios'   => $cambios,
                            'archivo'   => $filename,
                        ]);

                        $resultado[] = [
                            'lista'     => $l['descripcion'],
                            'file_url'  => $app->urlFor('LP:download', ['id' => $generado['id']]),
                        ];
                    } catch (\Exception $e) {
                        $resultado[] = [
                            'lista' => $l['descripcion'],
                            'error' => $e->getMessage(),
                        ];
                    }
                } else {
                    $resultado[] = [
                        'lista' => $l['descripcion'],
                        'error' => 'No se pudo generar la lista',
                    ];
                }
            }

            $this->responseJson([
                'success' => true,
                'data' => $resultado,
            ]);
        }
    }

    public function download($id)
    {
        $lp = $this->db->lp_generado[$id];

        if (!$lp) {
            throw new \Exception("No se encontró la lista de precios con ID $id");
        }

        $fileName = FOLDER_LP . $lp['archivo'];
        if (file_exists($fileName)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Type: application/force-download");
            header('Content-Disposition: attachment; filename=' . urlencode(basename($fileName)));
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            ob_clean();
            flush();
            readfile($fileName);
        } else {
            throw new \Exception("No se encontró el archivo $fileName");
        }
    }

    // public function ver($id) {
    //     $app = $this->app;
    //     $db = $this->db;
    //
    //     // Datos de la lista de precios
    //     $id = (int)$id;
    //     $lp = $db->lp[$id];
    //     $grupo = $lp->grupo;
    //     $template = $lp->cabecera['template'];
    //     $notas = $lp['notas'];
    //
    //     // Articulos
    //     $sth = $this->pdo->prepare("
    //         SELECT
    //             a.codigo,
    //             a.descripcion,
    //             a.precio,
    //             a.familia_id,
    //             f.nombre AS familia_nombre,
    //             a.marca_id,
    //             m.nombre AS marca_nombre
    //         FROM
    //             articulo a
    //         JOIN
    //             familia f ON a.familia_id = f.id
    //         JOIN
    //             marca m ON a.marca_id = m.id
    //         JOIN
    //             lp_articulo d ON d.articulo_id = a.id
    //         WHERE
    //             d.lp_id = ?
    //         ORDER BY
    //             f.orden, m.orden, a.codigo
    //     ");
    //     $sth->execute([$id]);
    //     $articulos = $sth->fetchAll(\PDO::FETCH_ASSOC);
    //
    //     $this->render('lp/print.twig', [
    //         'numero' => 9999,
    //         'fecha' => new \DateTime(),
    //         'grupo' => $grupo,
    //         'notas' => $notas,
    //         'template' => $template,
    //         'articulos' => $articulos,
    //     ]);
    // }
}
