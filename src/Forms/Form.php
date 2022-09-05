<?php


namespace Forms;

use App\Message;
use DateTimeInterface;
use Exception;

class Form
{
    /**
     * @var Object
     */
    private $instance;

    /**
     * @var array
    */
    private $errors = [];

    public function __construct($instance, array $errors = [])
    {
        $this->instance = $instance;
        $this->errors = $errors;
    }

    public function getValue(string $key): ?string
    {
        if (!empty($this->instance)) {
            $getter = 'get' . ucfirst($key);
            if (!method_exists($this->instance, $getter)) {
                throw new Exception("Nous avons pas pu trouver la methode $getter dans l'object {$this->instance}");
            }

           $value = $this->instance->$getter();

            if ($value instanceof DateTimeInterface) {
                    return $value->format('d-m-Y H:m:s');
            }

           return $value;
        }

        return null;
    }


    public function field ($key, $label, array $attributes = []) : string
    {
        $type = $attributes['type'] ?? 'text';
        $placeholder = $attributes['holder'] ?? '';
        list($has, $error) = Message::feedback($key, $this->errors);
        $value = $this->getValue($key);
        if ($type === 'text') {
            $input = $this->input($key, $value, $placeholder, $has, $error);
        } elseif ($type === 'textarea') {            
            $input = $this->textarea($key, $value, $has, $error);
        }

        return "<label for=\"$key\"> $label </label>$input";
    }

    private function input($key, $value = null, $placeholder = null, string $has, string $error): string
    {
        return "<input type=\"text\" name=\"$key\" id=\"$key\"  value=\"$value\"  class=\"form-control {$has}\" placeholder=\"{$placeholder} \">$error";
    }

    private function textarea($key, $value, string $has, string $error): string
    {
        return "<textarea name=\"$key\" id=\"$key\" class=\"form-control {$has}\" >{$value}</textarea>$error";
    }

    public function submit ($value, $color = 'primary'): string
    {
        return "<button type=\"submit\" class=\"btn-sm btn btn-$color mt-3 mb-3\">$value</button>";
    }
}