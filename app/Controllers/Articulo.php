<?php
namespace App\Controllers;

use App\Helpers\Datatable;
use App\Helpers\Settings;
use App\Helpers\Helper;
use \Exception;
use \DateTime;
use \NotORM_Literal;

class Articulo extends Controller
{
    private function findBy($field, $value, $depositoId)
    {
        $db = $this->db;

        $articulo = $db
            ->articulo
            ->select('id', 'codigo', 'descripcion', 'costo', 'precio')
            ->where($field, $value)
            ->fetch();

        if ($articulo) {
            $articuloId = (int) $articulo['id'];

            if ($depositoId) {
                $stock = $db
                    ->v_stock_deposito
                    ->select('cantidad')
                    ->where('articulo_id', $articuloId)
                    ->and('deposito_id', $depositoId)
                    ->fetch();
            } else {
                $stock = $db
                    ->v_stock
                    ->select('cantidad')
                    ->where('articulo_id', $articuloId)
                    ->fetch();
            }

            $stockCantidad = 0;
            if ($stock) {
                $stockCantidad = (float) $stock['cantidad'];
            }

            $articulo['stock'] = $stockCantidad;
        }

        if ($articulo) {
            $this->responseJson([
                'success' => true,
                'data' => $articulo
            ]);
        } else {
            $this->responseJson([
                'success' => false
            ]);
        }
    }

    private function createOrEdit($id=0)
    {
        $db = $this->db;

        $articulo = null;
        $stock = null;

        if ($id > 0) {
            $articulo = $db->articulo[$id];

            if ($articulo) {
                $sth = $this->pdo->prepare("
                    SELECT
                        d.id AS id,
                        d.nombre AS nombre,
                        s.cantidad AS cantidad
                    FROM
                        deposito d
                    LEFT JOIN
                        v_stock_deposito s ON s.deposito_id = d.id AND s.articulo_id = ?
                ");
                $sth->execute([$id]);
                $stock = $sth->fetchAll();
            } else {
                throw new Exception("No se encontró el artículo $id");
            }
        }

        $marcas = $db->marca->fetchPairs('id', 'nombre');
        $familias = $db->familia->fetchPairs('id', 'nombre');
        $proveedores = $db->proveedor->fetchPairs('id', 'nombre');
        $depositos = $db->deposito->fetchPairs('id', 'nombre');

        $this->render('articulo/form.twig', [
            'articulo' => $articulo,
            'familias' => $familias,
            'marcas' => $marcas,
            'proveedores' => $proveedores,
            'stock' => $stock,
            'depositos' => $depositos,
        ]);
    }

    public function index()
    {
        $db = $this->db;

        $familias = $db->familia->fetchPairs('id', 'nombre');
        $marcas = $db->marca->fetchPairs('id', 'nombre');
        $proveedores = $db->proveedor->fetchPairs('id', 'nombre');

        $this->render('articulo/index.twig', [
            'familias' => $familias,
            'marcas' => $marcas,
            'proveedores' => $proveedores,
        ]);
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
            'descripcion' => $post['descripcion'],
            'marca_id' => $post['marca'],
            'familia_id' => $post['familia'],
            'proveedor_id' => $post['proveedor'],
            'costo' => $post['costo'],
            'ganancia' => $post['ganancia'],
            'precio' => $post['precio'],
            'stock_minimo' => $post['minimo'],
            'notas' => $post['notas']
        ];

        try {
            if ($id === 0) {
                $db->articulo->insert($values);
            } else {
                $articulo = $db->articulo[$id];
                $articulo->update($values);
            }
        } catch (Exception $e) {
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        $this->app->flash('success', 'Los datos del artículo \'' . $values['codigo'] . '\' fueron actualizados');
        $this->responseJson([
            'success' => true,
        ]);
    }

    public function delete($id)
    {
        $db = $this->db;

        try {
            $affected = $db->articulo[$id]->delete();

            if ($affected > 0) {
                $this->responseJson([
                    'success' => true
                ]);
            } else {
                $this->responseJson([
                    'success' => false,
                    'message' => "No se pudo eliminar el artículo ID $id"
                ]);
            }
        } catch (Exception $e) {
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function datatable($limitado=false)
    {
        $request = $this->request;

        if (!$request->isAjax()) {
            return;
        }

        $app = $this->app;
        $request = $app->request;
        $filtro = $request->get('filtro');
        $where = [];

        if (isset($filtro['familia_id'])) {
            $where[] = "familia_id = " . filter_var($filtro['familia_id'], FILTER_SANITIZE_NUMBER_INT);
        }

        if (isset($filtro['marca_id'])) {
            $where[] = "marca_id = " . filter_var($filtro['marca_id'], FILTER_SANITIZE_NUMBER_INT);
        }

        if (isset($filtro['proveedor_id'])) {
            $where[] = "proveedor_id = " . filter_var($filtro['proveedor_id'], FILTER_SANITIZE_NUMBER_INT);
        }

        $dt = new Datatable(Settings::get('db'), 'v_articulo', 'id', join(' AND ', $where));

        $dt->addColumn('id', 'DT_RowId', function ($d, $row) {
            return 'row_' . $d;
        })
        ->addColumn('id')
        ->addColumn('codigo')
        ->addColumn('descripcion', null, function ($d, $row) use ($app) {
            return '<a href="' . $app->urlFor('Articulo:edit', ['id' => $row['id']]) . '">' . $d . '</a>';
        })
        ->addColumn('stock_minimo')
        ->addColumn('stock')
        ->addColumn('costo', null, function ($d, $row) {
            return '<input type="text" class="form-control text-right editable costo" data-field="costo" data-id="' . $row['id'] . '" value="' . $d . '">';
        })
        ->addColumn('ganancia', null, function ($d, $row) {
            return '<input type="text" class="form-control text-right editable ganancia" data-field="ganancia" data-id="' . $row['id'] . '" value="' . $d . '">';
        })
        ->addColumn('precio', null, function ($d, $row) {
            return '<input type="text" class="form-control text-right editable precio" data-field="precio" data-id="' . $row['id'] . '" value="' . $d . '">';
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

    public function ultimoPrecio($id)
    {
        if (!$this->request->isAjax()) {
            return;
        }

        $db = $this->db;
        $articuloId = (int) $id;

        $ultimo = $db
            ->articulo_precio_historico
            ->where('articulo_id', $articuloId)
            ->order('fecha DESC')
            ->fetch();

        $modificado = $db->articulo->select('precio_modificado')[$articuloId];

        $info = '';

        if ($modificado) {
            $info .= '<small class="text-muted">Modificado el</small><br>';
            $info .= '<strong>' . Helper::formatDate($modificado['precio_modificado'], 'd/m/y H:i') . '</strong><br>';
        }

        if ($ultimo) {
            $info .= '<small class="text-muted">Precio anterior</small><br>';
            $info .= '<strong>$' . number_format($ultimo['precio'], 2, ',', '.') . '</strong>';
        }

        if ($info) {
            echo "<div class=\"text-center\">$info</div>";
        }
    }

    public function savePrecio()
    {
        $db = $this->db;
        $post = $this->request->post();

        $id = (int) $post['id'];
        $field = $post['field'];
        $value = (float) $post['value'];

        $db->transaction = 'BEGIN';
        $articulo = $db
            ->articulo
            ->select('id, costo, ganancia, precio')[$id];

        try {
            if ($field === 'precio') {
                $precio = $value;
            } else {
                $articulo[$field] = $value;

                $costo = (float) $articulo['costo'];
                $ganancia = (float) $articulo['ganancia'];
                $precio = round($costo * (1 + $ganancia/100), 2);
            }

            $articulo['precio'] = $precio;
            $articulo->update();
            $db->transaction = 'COMMIT';
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $error = $e->getMessage();
        }

        if (isset($error)) {
            $this->responseJson([
                'success' => false,
                'message' => $error,
            ]);
        } else {
            $articulo = $db
                ->articulo
                ->select('costo, ganancia, precio')
                ->where('id', $id)
                ->fetch();

            $this->responseJson([
                'success' => true,
                'data' => [
                    'id' => $id,
                    'costo' => (float) $articulo['costo'],
                    'ganancia' => (float) $articulo['ganancia'],
                    'precio' => (float) $articulo['precio'],
                ],
            ]);
        }
    }

    public function all()
    {
        $db = $this->db;
        $request = $this->request;

        $q = trim($request->get('q'));
        $l = (int) $request->get('l');
        $familiaId = (int) $request->get('familia');
        $marcaId = (int) $request->get('marca');

        $articulos = $db->articulo->select('id', 'codigo', 'descripcion', 'precio');

        if ($q) {
            $articulos->where('codigo LIKE ?', $q . '%')->or('descripcion LIKE ?', '%' . $q . '%');
        }

        if ($familiaId) {
            $articulos->where('familia_id', $familiaId);
        }

        if ($marcaId) {
            $articulos->where('marca_id', $marcaId);
        }

        if ($l > 0) {
            $articulos->limit($l);
        }

        $articulos->order('codigo');

        $this->responseJson([
            'data' => Helper::serializeResult($articulos)
        ]);
    }

    public function find($id)
    {
        $depositoId = (int) $this->app->request->get('deposito');
        $this->findBy('id', (int) $id, $depositoId);
    }

    public function findCodigo($codigo)
    {
        $depositoId = (int) $this->app->request->get('deposito');
        $this->findBy('codigo', $codigo, $depositoId);
    }

    public function stock()
    {
        $request = $this->request;
        $db = $this->db;

        $articuloId = (int) $request->get('articulo');
        $depositoId = (int) $request->get('deposito');

        if ($depositoId === 0 || $articuloId === 0) {
            $this->responseJson([
                'success' => false
            ]);
            return;
        }

        $stock = (new App\Models\Articulo($this->pdo))->stock($articuloId, $depositoId);

        $this->responseJson([
            'success' => true,
            'stock' => $stock,
        ]);
    }

    public function movimientos()
    {
        $request = $this->request;
        $db = $this->db;

        $depositoId = (int)$request->get('deposito');
        $articuloId = (int)$request->get('articulo');
        $desde = DateTime::createFromFormat('d/m/Y', $request->get('desde'));
        $saldoAnterior = 0;

        $movimientos = $db->stock_movimiento;
        $movimientosAnteriores = $db->stock_movimiento;

        if ($depositoId) {
            $movimientos->where('deposito_id', $depositoId);
            $movimientosAnteriores->where('deposito_id', $depositoId);
        }

        if ($articuloId) {
            $movimientos->where('articulo_id', $articuloId);
            $movimientosAnteriores->where('articulo_id', $articuloId);
        }

        if ($desde) {
            $saldoAnterior =  (float)$movimientosAnteriores
                ->where('DATE(fecha) < ?', $desde->format('Y-m-d'))
                ->sum("CASE WHEN tipo = 'E' THEN cantidad ELSE -cantidad END");

            $movimientos->where('DATE(fecha) >= ?', $desde->format('Y-m-d'));
        }

        $movimientos->order('fecha');

        $this->render('articulo/movimientos.twig', [
            'movimientos' => $movimientos,
            'saldoAnterior' => $saldoAnterior,
        ]);
    }

    public function aumento()
    {
        $db = $this->db;

        $opciones = [
            'ct' => "Aumentar los precios de lista",
            'pv' => "Aumentar los precios de venta",
            'gc' => "Cambiar los porcentajes de ganancia",
            'rc' => "Recalcular los precios de venta",
        ];

        $this->render('articulo/aumento.twig', [
            'marcas' => $db->marca->fetchPairs('id', 'nombre'),
            'familias' => $db->familia->fetchPairs('id', 'nombre'),
            'proveedores' => $db->proveedor->fetchPairs('id', 'nombre'),
            'opciones' => $opciones,
        ]);
    }

    public function aumentoSave()
    {
        $db = $this->db;
        $request = $this->request;

        $familiaId = (int) $request->post('familia');
        $marcaId = (int) $request->post('marca');
        $proveedorId = (int) $request->post('proveedor');
        $accion = trim($request->post('accion'));
        $valor = (float) $request->post('valor');

        $articulos = $db->articulo;

        if ($familiaId) {
            $articulos->where('familia_id', $familiaId);
        }
        if ($marcaId) {
            $articulos->where('marca_id', $marcaId);
        }
        if ($proveedorId) {
            $articulos->where('proveedor_id', $proveedorId);
        }

        $db->transaction = 'BEGIN';

        try {
            switch ($accion) {
                case 'ct':
                    $articulos->update([
                        'costo' => new NotORM_Literal('ROUND(costo * ?, 2)', (1+$valor/100))
                    ]);
                    break;
                case 'pv':
                    $articulos->update([
                        'precio' => new NotORM_Literal('ROUND(precio * ?, 2)', (1+$valor/100))
                    ]);
                    break;
                case 'gc':
                    $articulos->update([
                        'ganancia' => $valor
                    ]);
                    break;
                case 'rc':
                    $articulos->update([
                        'precio' => new NotORM_Literal(
                            'ROUND(costo * (1+ganancia/100), 2)'
                        )
                    ]);
                    break;
            }

            $db->transaction = 'COMMIT';
        } catch (Exception $e) {
            $db->transaction = 'ROLLBACK';
            $this->responseJson([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        $this->app->flash('success', 'Se realizaron cambios en los precios');
        $this->responseJson([
            'success' => true
        ]);
    }
}
