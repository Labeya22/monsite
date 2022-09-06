<?php


namespace App;

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
            $getter = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

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
        $database = $attributes['database'] ?? [];
        $value = $this->getValue($key);
        list($has, $error) = Message::feedback($key, $this->errors);
        if ($type === 'text') {
            $input = $this->input($key, $value, $placeholder, $has, $error);
        } elseif ($type === 'textarea') {            
            $input = $this->textarea($key, $value, $has, $error);
        } elseif ($type === 'select') {    
            $options = $this->options($database, $placeholder, $value);    
            $input = $this->select($key, $options,  $has, $error);
        } elseif ($type === 'checkbox') {
            $v = $attributes['value'] ?? '';    
            return $this->checkbox($key, $v, $label);
        }

        return "<label for=\"$key\"> $label </label>$input";
    }

    private function input($key, $value = null, $placeholder = null, string $has = '', string $error = ''): string
    {
        return "<input type=\"text\" name=\"$key\" id=\"$key\"  value=\"$value\"  class=\"form-control {$has}\" placeholder=\"{$placeholder} \">$error";
    }

    private function select($key, string $options, string $has = '', string $error = ''): string
    {
        return "<select name=\"$key\" id=\"$key\" class=\"form-control {$has}\">$options</select>$error";
    }

    private function options($database, string $placeholder, ?string $submit = null): string
    {
         
        $options = array_map(function ($option) use ($database, $submit) {
            $content = $option[$database['content']];
            $value = $option[$database['value']];
            if ($value === $submit) {
                $submit = 'selected';
            }
            return "<option value=\"$value\" $submit>$content</option>";
        }, $database['data']);
        return "<option value=\"\"> $placeholder</option>" . implode(PHP_EOL, $options);
    }

    private function textarea($key, $value, string $has = '', string $error = ''): string
    {
        return "<textarea name=\"$key\" id=\"$key\" class=\"form-control {$has}\" >{$value}</textarea>$error";
    }

    public function submit ($value, $color = 'primary'): string
    {
        return "<button type=\"submit\" class=\"btn-sm btn btn-$color mt-3 mb-3\">$value</button>";
    }

    public function checkbox($key, $value, $remember): string
    {
        return 
        "<div class=\"form-check form-switch\">
            <input class=\"form-check-input\" type=\"checkbox\" id=\"{$key}\" name=\"{$key}\" value=\"{$value}\">
            <label for=\"$key\" class=\"text-muted\"> {$remember} </label>
        </div>";
    }
}