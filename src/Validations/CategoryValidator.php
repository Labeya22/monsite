<?php

namespace Validations;

use Tables\CategoryTable;
use Validator\Validator;

class CategoryValidator
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     *
     * @param array $data
     */
    public function __construct(array $data =  [], ?CategoryTable $post = null, $categoryId = null)
    {
        $this->validator = new Validator($data);

        // pour les champs vide
        $this->validator
            ->isEmpty('category')
            ->min('category');
        
        if (!is_null($categoryId)) {
            $this->validator->unique($post, ['category'], $categoryId);
        } else {
            $this->validator->unique($post, ['category']);
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