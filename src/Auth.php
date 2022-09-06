<?php

namespace App;

use App\Routes\Router;

class Auth
{
    /**
     * @var Router
     */
    private static $router;

    private static $instance;

    static function route(Router $router): void
    {
        self::$router = $router;
    }

    static function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function write($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    static function ok(): void
    {
        if (isset($_SESSION['auth'])) {
            r(self::$router->generateUri('admin.index'));
        }
    }


    static function check(): void
    {
        if (!isset($_SESSION['auth'])) {
            Flash::instance()->write('danger', 'Accès interdit');
            r(self::$router->generateUri('auth.index'));
        }
    }
}