<?php

namespace App\Validation;

use App\Validation\BaseValidator;

class FileValidator extends BaseValidator
{
    public static function validateFile($file)
    {
        $errors = [];

        if ($file['size'] > 3 * pow(2, 20)) {
            array_push($errors, 'Файл слишком большой ('.$file['size'].' байт)');
        }

        $extension = strtolower(pathinfo($file['name'])['extension']) ?? "";
        $type = $file['type'];

        if (!($type == "image/png" && $extension == 'png') &&
                !($type == "image/jpeg" && ($extension == 'jpg' || $extension == 'jpeg'))) {
            array_push($errors, 'Неподдерживаемый тип файла');
        }
        return $errors;
    }
}
