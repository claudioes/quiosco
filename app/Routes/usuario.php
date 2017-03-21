<?php
use App\Controllers\Usuario;

$app->group('/usuario', $permitido($app, 'admin'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Usuario($app))->index();
    })->name('Usuario:index');

    // NUEVO
    $app->get('/nuevo', function() use ($app){
        (new Usuario($app))->create();
    })->name('Usuario:create');

    // MODIFICAR
    $app->get('/modificar/:id', function($id) use ($app) {
        (new Usuario($app))->edit($id);
    })->name('Usuario:edit');

    // ELIMINAR
    $app->delete('/:id', function($id) use ($app) {
        (new Usuario($app))->delete($id);
    })->name('Usuario:delete');

    // CAMBIAR PASSWORD
    $app->get('/cambiarpassword/:id', function($id) use ($app) {
        (new Usuario($app))->changePassword($id);
    })->name('Usuario:changePassword');

    // DATATABLE
    $app->get('/datatable', function() use ($app) {
        (new Usuario($app))->datatable();
    })->name('Usuario:datatable');

    // GUARDAR
    $app->post('/guardar', function() use ($app) {
        (new Usuario($app))->save();
    })->name('Usuario:save');

    // GUARDAR PASSWORD
    $app->post('/guardarpassword', function() use ($app) {
        (new Usuario($app))->savePassword();
    })->name('Usuario:savePassword');
});
