<?php

namespace App\Renderer;


class Renderer
{
    private $views;

    private $globals = [];


    public function __construct($views)
    {
        $this->views = $views;
    }

    public function global ($key, $value): void
    {
        $this->globals[$key] = $value;
    }

    public function render (string $path, $params = [], string $layout = 'layout')
    {
        $view = $this->views . str_replace('/', DIRECTORY_SEPARATOR, $path) . '.php';
        $layout = $this->views . 'layout' . DIRECTORY_SEPARATOR  . $layout . '.php';

        ob_start();
        if (!empty($params)) {
           extract($params);
        } if (!empty($this->globals)) {
           extract($this->globals);
        }
        require_once($view);
        $content = ob_get_clean();
        require_once($layout);
    }
}