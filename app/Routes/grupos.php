<?php
use App\Controllers\Grupo;

$app->group("/grupo", $permitido($app, 'grupo'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Grupo($app))->index();
    })->name('Grupo:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Grupo($app))->create();
    })->name('Grupo:create');

    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Grupo($app))->edit($id);
    })->name('Grupo:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Grupo($app))->delete($id);
    })->name('Grupo:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Grupo($app))->datatable();
    })->name('Grupo:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Grupo($app))->save();
    })->name('Grupo:save');
});
