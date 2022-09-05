<?php

namespace App;


class Message
{
    static function generate(array $message = []): ?string
    {
        if (!empty($message)) {
            $index = array_key_first($message);
            
            if (is_array($message[$index])) {

                $map = array_map(function ($value) {
                    return $value;
                }, $message[$index]);

                $messages = implode('<br>', $map);
            }  else {
               $messages =  $message[$index];
            }

            return "<div class=\"alert alert-{$index}\"> $messages </div>";
        }

        return null;
    }


    static function feedback($key, $errors = []): array
    {
        $has = '';
        $error = '';
        if (!empty($errors) && isset($errors[$key])) {
            $has = 'is-invalid';
            $error = " <div class=\"invalid-feedback\">" . implode('<br>', $errors[$key]) . "</div>";
        }

        return [$has, $error];
    }
}