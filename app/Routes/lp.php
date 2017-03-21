<?php
use App\Controllers\LP;

$app->group("/lp", $permitido($app, 'articulo.lp'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new LP($app))->index();
    })->name('LP:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new LP($app))->create();
    })->name('LP:create');

    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new LP($app))->edit($id);
    })->name('LP:edit');

    // MODIFICAR
    // $app->get('/ver/:id', function($id) use ($app) {
    //     (new LP($app))->ver($id);
    // })->name('LP:view');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new LP($app))->delete($id);
    })->name('LP:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new LP($app))->datatable();
    })->name('LP:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new LP($app))->save();
    })->name('LP:save');

    // DOWNLOAD
    $app->get('/descargar/:id', function($id) use ($app) {
        (new LP($app))->download($id);
    })->name('LP:download');

    // GENERADOS
    $app->get('/generados/:id', function($id) use ($app) {
        (new LP($app))->generados($id);
    })->name('LP:generados');

    // GENERAR
    $app->map('/generar(/:id)', function($id = null) use ($app) {
        (new LP($app))->generar($id);
    })->name('LP:generar')->via('GET', 'POST');
});
