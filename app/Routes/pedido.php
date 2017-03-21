<?php
use App\Controllers\Pedido;

$app->group("/pedido", $permitido($app, 'pedido'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Pedido($app))->index();
    })->name('Pedido:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Pedido($app))->create();
    })->name('Pedido:create');

    // MODIFICAR
    // $app->get('/modificar/:id', function($id) use ($app) {
    //     (new Pedido($app))->edit($id);
    // })->name('Pedido:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Pedido($app))->delete($id);
    })->name('Pedido:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Pedido($app))->datatable();
    })->name('Pedido:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Pedido($app))->save();
    })->name('Pedido:save');

    // IMPRIMIR
    $app->get('/imprimir/:id', function($id) use ($app) {
        (new Pedido($app))->printPage($id);
    })->name('Pedido:printPage');

    $app->get('/articulos', function() use ($app) {
        (new Pedido($app))->articulos();
    })->name('Pedido:articulos');
});
