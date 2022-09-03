<?php

namespace App;

class Flash
{
    /**
     * @var self
     */
    private static $instance = null;

    static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public function __construct()
    {
        on();
    }

    public function write($key, $value): void
    {
        $_SESSION['flash'][$key] = $value;
    }

    public function has ($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function get(): array
    {
        $flash = [];
        if ($this->has('flash')) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        return $flash;
    }
}