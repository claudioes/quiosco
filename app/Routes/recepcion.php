<?php
use App\Controllers\Recepcion;

$app->group("/recepcion", $permitido($app, 'recepcion'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Recepcion($app))->index();
    })->name('Recepcion:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Recepcion($app))->create();
    })->name('Recepcion:create');

    // VER
    $app->get('/:id/ver', function($id) use ($app) {
        (new Recepcion($app))->view($id);
    })->name('Recepcion:view');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Recepcion($app))->delete($id);
    })->name('Recepcion:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Recepcion($app))->datatable();
    })->name('Recepcion:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Recepcion($app))->save();
    })->name('Recepcion:save');
});
