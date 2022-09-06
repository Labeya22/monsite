<?php

namespace Validator;

class Validator
{
    
    private $errors = [];

    private $validator = [];


    public function __construct(array $validator)
    {
        $this->validator = $validator;
    }

    public function slug($key): self
    {
        $patters = "/^[0-9a-z\_-]+$/";
        if (!preg_match($patters, $this->getValue($key))) {
            $this->Errors('slug', $key, ['chiffres, lettres miniscules, _ , des tirets']);
        }
        return $this;
    }

    public function isEmpty($key): self
    {
        $value = $this->getValue($key);
        if (empty($value) && !is_null($value)) {
            $this->Errors('empty', $key, [$key]);
        }

        return $this;
    }

    public function min($key, $min = 3): self
    {
        $value = $this->getValue($key);
        if (strlen($value) < $min) {
            $this->Errors('min', $key, [$min]);
        }

        return $this;

    }

    /**
     *
     * @param Table $instance
     * @param array $keys
     * @param string|null $index
     * @return self
     */
    public function unique($instance, array $keys, ?string $index = null): self
    {
        if (!is_null($index)) {
            foreach ($keys as $k) {
                $value = $this->getValue($k);
                if (!empty($instance->find($k, $value, $index))) {
                    $this->Errors('unique', $k);
                }
            }
        } else {
            foreach ($keys as $k) {
                $value = $this->getValue($k);
                if (!empty($instance->find($k, $value))) {
                    $this->Errors('unique', $k);
                }
            }
        }

        return $this;
    }

    public function uniques($instance, $keys, $message,  $indexes = null): self
    {
        $fields = [];

        foreach ($keys as $k) {
            $value = $this->getValue($k);
            $fields[$k] = $value;
        }

        if (!empty($instance->findAll($fields, $indexes))) {
            $this->Errors('unique', 'both', [$message]);
        }



        return $this;

    }


    private function getValue($key): string
    {
        if (isset($this->validator[$key])) {
            return $this->validator[$key];
        }
        
        return '';
        
    }

    private function Errors($rule, $key, $params = []): void
    {
        $this->errors[$key][] = (string)(new ValidatorError($rule, $key, $params));
    }


    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validate():bool
    {
        return empty($this->errors);
    }


}