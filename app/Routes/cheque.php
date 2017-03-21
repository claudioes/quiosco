<?php
use App\Controllers\Cheque;

$app->group("/cheque", $permitido($app, 'cheque'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Cheque($app))->index();
    })->name('Cheque:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Cheque($app))->create();
    })->name('Cheque:create');

    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Cheque($app))->edit($id);
    })->name('Cheque:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Cheque($app))->delete($id);
    })->name('Cheque:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Cheque($app))->datatable();
    })->name('Cheque:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Cheque($app))->save();
    })->name('Cheque:save');
});
