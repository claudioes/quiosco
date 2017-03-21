<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');

// CONSTANTES

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__DIR__)) . DS);
define('APP_NAME', 'Quiosco Web');
define('APP_SESSION_NAME', 'quiosco');
define('VERSION_FILE', ROOT . 'version.txt');
define('DATE_FORMAT', 'd/m/Y');
define('DATETIME_FORMAT', 'd/m/Y h:i');

// VERSION

if (file_exists(VERSION_FILE)) {
    define('APP_VERSION', file_get_contents(VERSION_FILE));
} else {
    define('APP_VERSION', date('YmdHis'));
}

// AUTOLOAD

require ROOT . 'vendor' . DS . 'autoload.php';

// CONFIGURACION

require ROOT . 'app' . DS . 'config.php';

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

// SESSION

session_name(APP_SESSION_NAME);
session_cache_limiter(false);
session_start();

// DB

$db = App\Helpers\Settings::get('db');
$pdo = new \PDO("mysql:host={$db['host']};dbname={$db['dbname']}", $db['user'], $db['pass']);
$pdo->exec('SET NAMES utf8');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// SLIM

$app = new Slim\Slim([
	'debug' => DEBUG,
    'view' => new \Slim\Views\Twig(),
	'templates.path' => ROOT . 'app' . DS . 'Views',
]);

// INJECTION

$app->pdo = $pdo;
$app->db = new NotORM($pdo);
$app->usuario = new App\Models\Usuario($pdo);

// TWIG

$app->view->parserExtensions = [new Slim\Views\TwigExtension()];
$app->view->parserOptions = [
    'debug' => DEBUG,
    'cache' => ROOT . 'app' . DS . 'Views' . DS . 'cache'
];

// Función para Twig que agrega la versión de la aplicación a un asset
// Por ejemplo: app.js >> app.20170301103000.js

$siteUrlWithVersion = new \Twig_SimpleFunction('siteUrlWithVersion', function ($string) use ($app) {
    $path = explode('.', ltrim($string, '/'));

    $req = $app->request();
    $url = $req->getUrl() . $req->getRootUri() . '/' . $path[0];

    $ext = '.' . APP_VERSION . '.' . $path[1];

    return "$url$ext";
});

$app->view->getEnvironment()->addFunction($siteUrlWithVersion);
$app->view->getEnvironment()->getExtension('core')->setNumberFormat(2, ',', '.');

// MIDDLEWARE

$permitido = function ($app, $permiso) {
    return function () use ($app, $permiso) {
        if (!$app->usuario->puede($permiso)) {
            $app->redirect($app->urlFor('denegado'));
        }
    };
};

// HOOKS

// Este "hook" se ejecuta antes de devolver cualquier ruta

$app->hook('slim.before.dispatch', function() use ($app) {
    $url = $app->request->getPath();

    $publicResources = [
        $app->urlFor('login'),
    ];

    $app->view()->setData([
        'app' => [
            'name' => APP_NAME,
            'debug' => DEBUG,
        ],
        'url' => [
            'path' => $url,
            //'root' => $app->request->getRootUri(),
            //'resource' => $app->request->getResourceUri(),
        ],
    ]);

    // Si el usuario está logueado, cargo la vista correspondiente.
    // Si no, redirigo al login

    if ($app->usuario->esValido) {
        $sidebar = simplexml_load_file(ROOT . 'app' . DS . 'sidebar.xml');
        $menu = simplexml_load_file(ROOT . 'app' . DS . 'menu.xml');

        $app->view()->setData([
            'sidebar'=> $sidebar,
            'menu' => $menu,
            'usuario' => $app->usuario,
        ]);
    } else if (!in_array($url, $publicResources)) {
        $app->redirect($app->urlFor('login'));
    }
});

// ROUTES

foreach (glob(ROOT . 'app/routes/*.php') as $filename) {
    require $filename;
}

// INDEX ROUTE

$app->get('/', function() use($app) {
	$app->render('index.twig');
})->name('home');
