<?php

$app->map('/login', function() use ($app) {
    if ($app->request->isGet()) {
        $app->render('login.twig');
    } else {
        $usuario = $app->usuario;
        $usr = $app->request->post('usuario');
        $psw = $app->request->post('password');

        $usuario->autenticar($usr, $psw);

        if ($usuario->esValido) {
            if (!$usuario->estaActivo) {
                $app->flash('error', 'El usuario está deshabilitado, consulte con el administrador');
                $app->redirect($app->urlFor('login'));
            } elseif (!$usuario->cumpleHorario()) {
                $app->flash('error', 'No puede usar este usuario en este momento, consulte con el administrador');
                $app->redirect($app->urlFor('login'));
            } else {
                $app->redirect($app->urlFor('home'));
            }
        } else {
            $app->flash('error', 'Usuario o contraseña incorrectos');
            $app->redirect($app->urlFor('login'));
        }
    }
})->via('GET', 'POST')->name('login');

$app->get('/logout', function() use ($app) {
    $app->usuario->limpiar();
    $app->redirect($app->urlFor('login'));
})->name('logout');

$app->get('/denegado', function() use ($app) {
    $app->render('template/denegado.twig', [], 403);
})->name('denegado');
