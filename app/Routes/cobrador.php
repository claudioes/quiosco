<?php
use App\Controllers\Cobrador;

$app->group("/cobrador", $permitido($app, 'cobrador'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Cobrador($app))->index();
    })->name('Cobrador:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Cobrador($app))->create();
    })->name('Cobrador:create');

    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Cobrador($app))->edit($id);
    })->name('Cobrador:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Cobrador($app))->delete($id);
    })->name('Cobrador:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Cobrador($app))->datatable();
    })->name('Cobrador:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Cobrador($app))->save();
    })->name('Cobrador:save');
});
