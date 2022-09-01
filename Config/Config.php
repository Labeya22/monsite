<?php

namespace Config;

use PDO;

class Config
{
    private const user = 'root';

    private const pass = '';

    private const host = '127.0.0.1';

    private const dbname = 'monsite';

    private static $instance = null;


    static function getPDO(): PDO
    {
        if (is_null(self::$instance)) {
            self::$instance = new PDO("mysql:host=" . self::host . ";dbname=" . self::dbname, self::user, self::pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$instance;
    }
}