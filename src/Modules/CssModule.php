<?php


namespace Modules;

use App\Routes\Router;
use App\Renderer\Renderer;

class CssModule
{
    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;

    public function __construct(Renderer $render, Router $router)
    {
        $this->renderer = $render;
        $this->router = $router;
        
        
        // la route vers asset
        $router->get('/public/assets/js/bootstrap.bundle.js', [$this, 'assets'], 'assets.js');
        $router->get('/public/assets/css/bootstrap.min.css', [$this, 'assets'], 'assets.css');

    }


    public function assets (){}

}