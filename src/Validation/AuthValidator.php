<?php

namespace App\Validation;

use App\Validation\BaseValidator;

class AuthValidator extends BaseValidator
{
    protected const NAME_FIELD = 'name';
    protected const EMAIL_FIELD = 'email';
    protected const PHONE_FIELD = 'phone';
    protected const PASSWORD_FIELD = 'password';

    protected const NAME_PATTERN = "/^([А-ЯЁ][а-яё-]{1,30}[\s]*)+$/u";
    protected const EMAIL_PATTERN = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
    protected const PHONE_PATTERN = "/^\+*[0-9]{0,1}\({0,1}[0-9]{1,4}\){0,1}[-\s\.0-9]*$/";

    public static function validateRegister($request)
    {
        echo 1;
        return self::validateRequest(
            $request,
            [ self::NAME_FIELD, self::EMAIL_FIELD, self::PHONE_FIELD, self::PASSWORD_FIELD ],
            [ self::NAME_FIELD => self::NAME_PATTERN,
                self::EMAIL_FIELD => self::EMAIL_PATTERN,
                self::PHONE_FIELD => self::PHONE_PATTERN ]
        );
    }

    public static function validateLogin($request)
    {
        return self::validateRequest(
            $request,
            [ self::EMAIL_FIELD, self::PASSWORD_FIELD ],
            [ self::EMAIL_FIELD => self::EMAIL_PATTERN ]
        );
    }
}
