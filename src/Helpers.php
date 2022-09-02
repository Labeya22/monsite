<?php


namespace App;


class Helpers
{

    static function hydrate($instance, $data): array
    {
        $hydrate = [];
        foreach($data as $k => $v) {
            
        }

        return $hydrate;
    }

    static function params($key, $value): string
    {
        return "?$key=$value";
    }

    static function getParams($key): int
    {
        if (!isset($_GET[$key])) return 1;
        
        $value = $_GET[$key];
        if ($value <= 0) {
            return 1;
        }

        return $value;
    }
}