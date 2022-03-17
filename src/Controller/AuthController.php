<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use use App\Pdo\UserPdo;
use App\Validation\AuthValidator;

class AuthController extends BaseController
{

    protected const REGISTER_FAILED = 
        'Не удалось зарегистрировать нового пользователя. Попробуйте позже';
    protected const LOGIN_FAILED = 
        'Вход не удался. Попробуйте позже';

    public function register(array $parameters): Response
    {
        $parameters = $this->escapeHtml($parameters);

        $errors = AuthValidator::validateRegister($parameters);
        if (!empty($errors)) {
            return $this->wrapErrors($errors);
        }

        try {
            $userPdo = new UserPdo();
            if ($userPdo->isEmailExist($parameters['email'])) {
                return $this->wrapErrors(['Данный email занят другим пользователем']);
            }
            $userId = $userPdo->save($parameters);

        } catch (Exception $exception) {
            return $this->wrapErrors([REGISTER_FAILED]);
        }

        $this->prepareSessionToLogin();
        return $this->wrapJson(['success' => true]);
    }

    public function login(array $parameters): Response
    {
        $parameters = $this->escapeHtml($parameters);

        $errors = AuthValidator::validateLogin($parameters);
        if (!empty($errors)) {
            return $this->wrapErrors($errors);
        }

        try {
            $usersPdo = new UserPdo();
            $user = $usersPdo->getUserByEmail($parameters['email']);

        } catch (Exception $exception) {
            return $this->wrapErrors([LOGIN_FAILED]);
        }

        if (empty($user)) {
            return $this->wrapErrors(['Неверный логин']);
        } elseif (!password_verify($parameters['password'], $user['password_hash'])) {
            return $this->wrapErrors(['Неверный пароль']);
        }

        $this->prepareSessionToLogin();
        return $this->wrapJson(['success' => true]);
    }

    public function logout(array $parameters): Response
    {
        $this->request->getSession()->clear();
        return (new Response())
            ->headers->set('Refresh', '0; url=index.php');
    }

    protected function prepareSessionToLogin()
    {
        $session = $this->request->getSession();
        $session->set('userId', $userId);
        $session->set('userName', $parameters['name']);
    }
}