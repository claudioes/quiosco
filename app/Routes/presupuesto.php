<?php
use App\Controllers\Presupuesto;

$app->group("/presupuesto", $permitido($app, 'presupuesto'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Presupuesto($app))->index();
    })->name('Presupuesto:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Presupuesto($app))->create();
    })->name('Presupuesto:create');

    // MODIFICAR
    // $app->get('/modificar/:id', function($id) use ($app) {
    //     (new Presupuesto($app))->edit($id);
    // })->name('Presupuesto:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Presupuesto($app))->delete($id);
    })->name('Presupuesto:delete');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Presupuesto($app))->datatable();
    })->name('Presupuesto:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Presupuesto($app))->save();
    })->name('Presupuesto:save');

    // BUSCAR
    // $app->get('/buscar/:id', function($id) use ($app) {
    //     (new Presupuesto($app))->find($id);
    // })->name('Presupuesto:find');

    // IMPRIMIR
    $app->get('/imprimir/:id', function($id) use ($app) {
        (new Presupuesto($app))->printPage($id);
    })->name('Presupuesto:printPage');
});
