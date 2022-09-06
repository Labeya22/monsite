<?php

namespace Validator;

class ValidatorError
{
    private $key;

    private $rule;

    private $params = [];

    private $messages = [
        'empty' => "est requis",
        'slug' => "doit  avoir que %s.",
        'unique' => "cette valeur est déjà utilisées",
        'uniques' => "%s",
        'min' => "doit avoir au moins %d catectères",
        'max' => "ne doit pas depasser %d catectères",
        'between' => "doit avoir entre %i et %i catectères"
    ];

    /**
     * ValidatorError Constructor
     *
     * @param string $rule
     * @param string $key
     * @param array $params
     */
    public function __construct(string $rule, string $key, $params = [])
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->params = $params;
    }

    public function __toString(): string
    {
       return  call_user_func_array('sprintf',  array_merge([$this->messages[$this->rule]], $this->params));
    }
}