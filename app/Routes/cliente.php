<?php

use App\Controllers\Cliente;

$app->group("/cliente", $permitido($app, 'cliente'), function() use ($app) {
    //INDEX
    $app->get('/', function() use ($app) {
        (new Cliente($app))->index();
    })->name('Cliente:index');

    //NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Cliente($app))->create();
    })->name('Cliente:create');

    //MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Cliente($app))->edit($id);
    })->name('Cliente:edit');

    //ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Cliente($app))->delete($id);
    })->name('Cliente:delete');

    //DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Cliente($app))->datatable();
    })->name('Cliente:datatable');

    //GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Cliente($app))->save();
    })->name('Cliente:save');

    //CUENTA CORRIENTE
    $app->get('/cc/:id', function($id) use ($app) {
        (new Cliente($app))->cc($id);
    })->name('Cliente:cc');

    //IMPRIMIR CUENTA CORRIENTE
    $app->get('/cc/:id/imprimir', function($id) use ($app) {
        (new Cliente($app))->printCC($id);
    })->name('Cliente:printCC');
});

$app->group("/cliente", function() use ($app) {
    //BUSCAR ID
    $app->get('/buscar/:id', function($id) use ($app) {
        (new Cliente($app))->find($id);
    })->name('Cliente:find');

    //BUSCAR CODIGO
    $app->get('/buscarcodigo/:codigo', function($codigo) use ($app) {
        (new Cliente($app))->findCodigo($codigo);
    })->name('Cliente:findCodigo');
});
