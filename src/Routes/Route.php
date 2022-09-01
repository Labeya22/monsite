<?php

namespace App\Routes;


class Route {

    private $path;

    private $callback;

    private $regex = [];

    private $matches = [];

    public function __construct(string $path, $callback)
    {
        $this->path = trim($path, '/');
        $this->callback = $callback;
    }


    public function regex ($key, $regex): self
    {
        $this->regex[$key] = $regex;

        return $this;
    }

    /**
     * @param string $url
     * 
     * @return bool
     */
    public function isMatch (string $url): bool
    {
        $path = preg_replace_callback("#:([\w]+)#", [$this, 'withParams'], $this->path);
        $regex = "#^$path$#";
        if (preg_match($regex, $url, $matches)) {
            array_shift($matches);
            $this->matches = $matches;
            return true;
        }

        return false;
    }

    /**
     * @param array $matches
     * 
     * @return string
     */
    private function withParams(array $matches): string
    {
        if (isset($this->regex[$matches[1]])) {
            return  '(' . $this->regex[$matches[1]] . ')';
        }
        
        return '([^/]+)';
    }

    /**
     * @return mixed
     */
    public function isRequire()
    {
        return call_user_func_array($this->callback, $this->matches);
    }

    public function params(array $params): string
    {
        $path = $this->path;
        
        foreach ($params as $key => $value) {
            $path = str_replace(":$key", $value, $path);
        }

        return $path;
    }
}