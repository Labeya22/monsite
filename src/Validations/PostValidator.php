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
            ->isEmpty('slug')
            ->isEmpty('content')
            ->isEmpty('name')
            ->slug('slug');
        
        if (!is_null($postId)) {
            $this->validator->unique($post, ['slug', 'name'], $postId);
        } else {
            $this->validator->unique($post, ['slug', 'name']);
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