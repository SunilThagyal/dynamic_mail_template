<?php

namespace App\Helpers;

class EmailTemplateHelper
{
    // Method to replace placeholders like {{name}} in the email template body
    public static function renderTemplate($template, $data)
    {
        return str_replace(
            array_map(fn($key) => "{{{$key}}}", array_keys($data)), // Replaces placeholders with {{key}}
            array_values($data), // Values from the $data array
            $template // Original template string
        );
    }
}

