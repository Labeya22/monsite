<?php

namespace Validations;

use Validator\Validator;

class UserValidator
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     *
     * @param array $data
     */
    public function __construct(array $data =  [])
    {
        $this->validator = new Validator($data);

        // pour les champs vide
        $this->validator
            ->isEmpty('username')
            ->isEmpty('password')
            ->min('password', 8)
            ->min('username', 5);
    }

    public function validate(): bool
    {
        return $this->validator->validate();
    }

    public function getErrors(): array
    {
        return $this->validator->getErrors();
    }
}