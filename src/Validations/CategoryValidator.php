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
            ->isEmpty('slug')
            ->min('slug')
            ->min('category')
            ->slug('slug');
        
        if (!is_null($categoryId)) {
            $this->validator->unique($post, ['slug', 'category'], $categoryId);
        } else {
            $this->validator->unique($post, ['category', 'slug']);
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