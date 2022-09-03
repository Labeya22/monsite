<?php

use App\Renderer\Renderer;
use App\Routes\Router;
use Modules\AdminModule;
use Modules\BlogModule;
use Modules\CategoryModule;

require __DIR__. DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$render = new Renderer(__DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

// route pour les scripts (css, js, ...)
define('S', dirname($_SERVER['SCRIPT_NAME']) . "public/assets/");

// instance de router
$url = explode('?', $_SERVER['REQUEST_URI']);
$router = new Router($url[0]);

$render->global('router', $router);
foreach ([
    BlogModule::class,
    CategoryModule::class,
    AdminModule::class
] as $module) {
    new $module($render, $router);
}

$router->run();


