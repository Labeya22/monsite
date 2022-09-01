<?php

use App\Renderer\Renderer;
use App\Routes\Router;
use Modules\BlogModule;
use Modules\CssModule;

require __DIR__. DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$render = new Renderer(__DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

// route pour les scripts (css, js, ...)
define('S', dirname($_SERVER['SCRIPT_NAME']) . "public/assets/");

// instance de router
$router = new Router($_SERVER['REQUEST_URI']);

// les modules à charger
$modules = [
    BlogModule::class,
    CssModule::class,
];



foreach ($modules as $module) {
    new $module($render, $router);
}

$router->run();


