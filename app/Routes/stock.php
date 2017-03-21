<?php
use App\Controllers\Stock;

// INVENTARIO
$app->group("/stock/inventario", $permitido($app, 'stock.inventario'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Stock($app))->indexInventario();
    })->name('Stock:indexInventario');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Stock($app))->createInventario();
    })->name('Stock:createInventario');

    // GUARDAR
    $app->post('/nuevo', function() use ($app) {
        (new Stock($app))->saveInventario();
    })->name('Stock:saveInventario');
});

// TRANSFERENCIA
$app->group("/stock/transferencia", $permitido($app, 'stock.transferencia'), function() use ($app) {
    // INDEX
    $app->get('/', function() use ($app) {
        (new Stock($app))->indexTransferencia();
    })->name('Stock:indexTransferencia');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Stock($app))->createTransferencia();
    })->name('Stock:createTransferencia');

    // GUARDAR
    $app->post('/nuevo', function() use ($app) {
        (new Stock($app))->saveTransferencia();
    })->name('Stock:saveTransferencia');
});

// MOVIMIENTO
$app->group("/stock/movimiento", $permitido($app, 'stock.movimiento'), function() use ($app) {
    // INDEX
    // $app->get('/', function() use ($app) {
    //     (new Stock($app))->indexTransferencia();
    // })->name('Stock:indexTransferencia');

    // NUEVO
    $app->get('/nuevo', function() use ($app) {
        (new Stock($app))->createMovimiento();
    })->name('Stock:createMovimiento');

    // GUARDAR
    $app->post('/nuevo', function() use ($app) {
        (new Stock($app))->saveMovimiento();
    })->name('Stock:saveMovimiento');
});
