<?php
use App\Controllers\Caja;

$app->group("/caja(/)", $permitido($app, 'caja'), function() use ($app) {
    // INDEX
    $app->get('', function() use ($app) {
        (new Caja($app))->index();
    })->name('Caja:index');

    // RECIBO
    $app->get('recibo', function() use ($app) {
        (new Caja($app))->recibo();
    })->name('Caja:recibo');

    // RECIBO VER
    $app->get('recibo/:id', function($id) use ($app) {
        (new Caja($app))->viewRecibo($id);
    })->name('Caja:viewRecibo');

    // RECIBO ELIMINAR
    $app->delete('recibo/:id', function($id) use ($app) {
        if ($app->usuario->esAdministrador) {
            (new Caja($app))->deleteRecibo($id);
        }
    })->name('Caja:deleteRecibo');

    // GUARDAR RECIBO
    $app->post('recibo', function() use ($app) {
        (new Caja($app))->saveRecibo();
    })->name('Caja:saveRecibo');

    // MOVIMIENTO DE CAJA
    $app->get('/movimiento', function() use ($app) {
        (new Caja($app))->movimiento();
    })->name('Caja:movimiento');

    // GUARDAR MOVIMIENTO DE CAJA
    $app->post('/movimiento', function() use ($app) {
        (new Caja($app))->saveMovimiento();
    })->name('Caja:saveMovimiento');

    // CIERRE
    $app->post('/cierre', function() use ($app) {
        (new Caja($app))->cierre();
    })->name('Caja:cierre');

    // IMPRIMIR CIERRE
    $app->get('/cierre/imprimir/:id', function($id) use ($app) {
        (new Caja($app))->printCierre($id);
    })->name('Caja:printCierre');

    //DATATABLE MOVIMIENTOS
    $app->get('/datatable/movimientos', function() use ($app) {
        (new Caja($app))->datatableMovimientos();
    })->name('Caja:datatableMovimientos');

    //DATATABLE CIERRES
    $app->get('/datatable/cierres', function() use ($app) {
        (new Caja($app))->datatableCierres();
    })->name('Caja:datatableCierres');

});
