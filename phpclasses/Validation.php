<?php

class Validation
{
    protected const NAME_FIELD = 'name';
    protected const EMAIL_FIELD = 'email';
    protected const PHONE_FIELD = 'phone';
    protected const PASSWORD_FIELD = 'password';

    protected const NAME_PATTERN = "/^([А-ЯЁ][а-яё-]{1,30}[\s]*)+$/u";
    protected const EMAIL_PATTERN = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
    protected const PHONE_PATTERN = "/^\+*[0-9]{0,1}\({0,1}[0-9]{1,4}\){0,1}[-\s\.0-9]*$/";

    protected const ID_PATTERN = "/^[0-9a-zA-Z]{8}$/";

    public static function checkId($id)
    {
        return preg_match(self::ID_PATTERN, $id);
    }

    public static function validateRegisterRequest($request)
    {
        return self::validateRequest(
            $request,
            [ self::NAME_FIELD, self::EMAIL_FIELD, self::PHONE_FIELD, self::PASSWORD_FIELD ],
            [ self::NAME_FIELD => self::NAME_PATTERN,
                self::EMAIL_FIELD => self::EMAIL_PATTERN,
                self::PHONE_FIELD => self::PHONE_PATTERN ]
        );
    }

    public static function validateLoginRequest($request)
    {
        return self::validateRequest(
            $request,
            [ self::EMAIL_FIELD, self::PASSWORD_FIELD ],
            [ self::EMAIL_FIELD => self::EMAIL_PATTERN ]
        );
    }

    protected static function validateRequest($request, $requiredFields, $patterns)
    {
        foreach ($request as $fieldName => $value) {
            unset($requiredFields[array_search($fieldName, $requiredFields)]);
        }

        $errors = [];

        if (!empty($requiredFields)) {
            foreach ($requiredFields as $fieldName) {
                array_push($errors, self::getEmptyFieldErrorMessage($fieldName));
            }
            return $errors;
        }

        foreach ($request as $fieldName => $value) {
            if ($value == null || $value == '') {
                array_push($errors, self::getEmptyFieldErrorMessage($fieldName));
                continue;
            }
            if (!isset($patterns[$fieldName])) {
                continue;
            }
            $pattern = $patterns[$fieldName];

            if (!preg_match($pattern, $value)) {
                array_push($errors, self::getBadFieldErrorMessage($fieldName));
            }
        }
        return $errors;
    }

    protected static function getEmptyFieldErrorMessage($fieldName)
    {
        return 'Поле '.$fieldName.' обязательное';
    }

    protected static function getBadFieldErrorMessage($fieldName)
    {
        return 'Поле '.$fieldName.' некорректное';
    }

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
