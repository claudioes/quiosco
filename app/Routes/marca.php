<?php
use App\Controllers\Marca;

$app->group("/marca", $permitido($app, 'marca'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Marca($app))->index();
    })->name('Marca:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Marca($app))->create();
    })->name('Marca:create');

    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Marca($app))->edit($id);
    })->name('Marca:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Marca($app))->delete($id);
    })->name('Marca:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Marca($app))->datatable();
    })->name('Marca:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Marca($app))->save();
    })->name('Marca:save');
});
