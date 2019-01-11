<?php
use App\Controllers\Articulo;

$app->group("/articulo", $permitido($app, ['articulo', 'articulo.limitado']), function() use ($app, $permitido) {
    // INDEX
    $app->get('/', function() use ($app) {
        if ($app->usuario->puede('articulo')) {
            (new Articulo($app))->index();
        } else {
            (new Articulo($app))->index(true);
        }
    })->name('Articulo:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Articulo($app))->create();
    })->name('Articulo:create');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        if ($app->usuario->puede('articulo')) {
            (new Articulo($app))->datatable();
        } else {
            (new Articulo($app))->datatable(true);
        }
    })->name('Articulo:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Articulo($app))->save();
    })->name('Articulo:save');
});

$app->group("/articulo", $permitido($app, 'articulo'), function() use ($app, $permitido) {
    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Articulo($app))->edit($id);
    })->name('Articulo:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Articulo($app))->delete($id);
    })->name('Articulo:delete');

    // PRECIO GUARDAR
    $app->post('/guardarprecio', $permitido($app, 'articulo.precios'), function() use ($app) {
        (new Articulo($app))->savePrecio();
    })->name('Articulo:savePrecio');

    // AUMENTO
    $app->map('/aumento', $permitido($app, 'articulo.aumento'), function() use ($app) {
        if ($app->request->isGet()) {
            (new Articulo($app))->aumento();
        } else {
            (new Articulo($app))->aumentoSave();
        }
    })->via('GET', 'POST')->name('Articulo:aumento');
});

$app->group("/articulo", function() use ($app, $permitido) {
    // TODOS
    $app->get('/todos', function() use ($app) {
        (new Articulo($app))->all();
    })->name('Articulo:all');

    // BUSCAR ID
    $app->get('/buscar/:id', function($id) use ($app) {
        (new Articulo($app))->find($id);
    })->name('Articulo:find');

    // BUSCAR CODIGO
    $app->get('/buscarcodigo/:codigo', function($codigo) use ($app) {
        (new Articulo($app))->findCodigo($codigo);
    })->name('Articulo:findCodigo');

    // DESCUENTO
    $app->get('/descuento', function() use ($app) {
        (new Articulo($app))->descuento();
    })->name('Articulo:descuento');

    $app->get('/stock', function() use ($app) {
        (new Articulo($app))->stock();
    })->name('Articulo:stock');

    $app->get('/movimientos', function() use ($app) {
        (new Articulo($app))->movimientos();
    })->name('Articulo:movimientos');
});
