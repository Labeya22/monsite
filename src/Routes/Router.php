<?php

namespace App\Routes;

use App\Exceptions\RouterException;

class Router {

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var array
     */
    private $nameRoutes = [];

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = trim($url, '/');
    }



    /**
     * Permet d'ajouter une route 
     * 
     * @param string|array $method
     * @param string $path
     * @param $callback
     * @param string|null $name
     * 
     * @return Route
     */
    private function addRoute ($method, string $path, $callback, ?string $name = null): Route
    {
        $route = new Route($path, $callback);
        if (is_array($method)) {
            $this->routes[$method[0]][] = $route;
            $this->routes[$method[1]][] = $route;
        } else {
            $this->routes[$method][] = $route;
        }


        if (!is_null($name)) {
            if (isset($this->nameRoutes[$name])) {
                throw new RouterException("Ce nom de route est déjà pris");
            }

            $this->nameRoutes[$name] = $route;
        }

        return $route;
    }



    public function get (string $path, $callback, ?string $name = null): Route
    {
        return $this->addRoute('GET', $path, $callback, $name);

    }


    public function post (string $path, $callback, ?string $name = null): Route
    {
        return $this->addRoute('POST', $path, $callback, $name);

    }

    public function both (string $path, $callback, ?string $name = null): Route
    {
        return $this->addRoute(['GET', 'POST'], $path, $callback, $name);

    }

    public function generateUri($name, $params = []): string
    {
        if (isset($this->nameRoutes[$name])) {
            return '/' . $this->nameRoutes[$name]->params($params);
        }

        throw new RouterException("Nous avons pas pu trouver une route qui a ce nom #$name");
    }

    /**
     * Permet d'executer les routes 
     * 
     * @return mixed
     */
    public function run ()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
           throw new RouterException("Aucune methode n'est définie");
        }

        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->isMatch($this->url)) {
                return $route->isRequire();
            }
        }
        
        throw new RouterException("Nous avons pas pu trouver une route repondant à votre demande");
    }


}