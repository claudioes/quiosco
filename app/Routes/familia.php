<?php
use App\Controllers\Familia;

$app->group("/familia", $permitido($app, 'familia'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Familia($app))->index();
    })->name('Familia:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Familia($app))->create();
    })->name('Familia:create');

    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Familia($app))->edit($id);
    })->name('Familia:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Familia($app))->delete($id);
    })->name('Familia:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Familia($app))->datatable();
    })->name('Familia:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Familia($app))->save();
    })->name('Familia:save');
});
