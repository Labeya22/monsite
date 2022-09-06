<?php

namespace Validations;

use Tables\PostCategoryTable;
use Validator\Validator;

class RelationValidator
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     *
     * @param array $data
     */
    public function __construct(array $data =  [], PostCategoryTable $post, $indexes = null)
    {
        $this->validator = new Validator($data);

        $this->validator->isEmpty('post_id');
        $this->validator->isEmpty('category_id');


        if (is_null($indexes)) {
            $this->validator->uniques($post, ['category_id', 'post_id'], 'cette relation existe');
        } else {
            $this->validator->uniques($post, ['category_id', 'post_id'], 'cette relation existe', $indexes);
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