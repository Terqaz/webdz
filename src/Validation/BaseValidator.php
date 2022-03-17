<?php 

namespace App\Validation;

class BaseValidator
{
	protected const ID_PATTERN = "/^[0-9a-zA-Z]{8}$/";

    public static function isIdCorrect($id)
    {
        return preg_match(self::ID_PATTERN, $id);
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

    private static function getEmptyFieldErrorMessage($fieldName)
    {
        return 'Поле '.$fieldName.' обязательное';
    }

    private static function getBadFieldErrorMessage($fieldName)
    {
        return 'Поле '.$fieldName.' некорректное';
    }
}