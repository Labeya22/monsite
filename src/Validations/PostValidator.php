<?php

namespace Validations;

use Tables\postTable;
use Validator\Validator;

class PostValidator
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     *
     * @param array $data
     */
    public function __construct(array $data =  [], ?postTable $post = null, $postId = null)
    {
        $this->validator = new Validator($data);

        // pour les champs vide
        $this->validator
            ->isEmpty('content')
            ->min('name')
            ->min('content')
            ->isEmpty('name');
        
        if (!is_null($postId)) {
            $this->validator->unique($post, ['name'], $postId);
        } else {
            $this->validator->unique($post, ['name']);
        }
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