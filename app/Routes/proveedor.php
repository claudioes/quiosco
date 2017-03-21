<?php

use App\Controllers\Proveedor;

$app->group("/proveedor", $permitido($app, 'proveedor'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Proveedor($app))->index();
    })->name('Proveedor:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Proveedor($app))->create();
    })->name('Proveedor:create');

    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Proveedor($app))->edit($id);
    })->name('Proveedor:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Proveedor($app))->delete($id);
    })->name('Proveedor:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Proveedor($app))->datatable();
    })->name('Proveedor:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Proveedor($app))->save();
    })->name('Proveedor:save');

    // DOCUMENTOS
    $app->get('/:proveedorId/documento', function($proveedorId) use ($app) {
        (new Proveedor($app))->documento($proveedorId);
    })->name('Proveedor:documento');

    // GUARDAR DOCUMENTO
    $app->post('/documento/guardar', function() use ($app) {
        (new Proveedor($app))->saveDocumento();
    })->name('Proveedor:saveDocumento');

    // DESCARGAR DOCUMENTO
    $app->get('/documento/descargar/:id', function($id) use ($app) {
        (new Proveedor($app))->downloadDocumento($id);
    })->name('Proveedor:downloadDocumento');

    // ELIMINAR DOCUMENTO
    $app->delete('/documento/:id', function($id) use ($app) {
        (new Proveedor($app))->deleteDocumento($id);
    })->name('Proveedor:deleteDocumento');
});

$app->group("/proveedor", function() use ($app) {
    // BUSCAR
    $app->get('/buscar/:id', function($id) use ($app) {
        (new Proveedor($app))->find($id);
    })->name('Proveedor:find');
});
