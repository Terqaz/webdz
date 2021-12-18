<?php

require_once "phpclasses/pdo/UserPdo.php";
require_once "phpclasses/Validation.php";

const LOGIN_FAILED = 'Вход не удался. Попробуйте позже';

header('Content-Type: application/json');


$loginRequest = $_POST;

$loginRequest = array_map(
    function ($v) {
       return htmlspecialchars($v);
   },
    $loginRequest
);

$errors = Validation::validateLoginRequest($loginRequest);
if (!empty($errors)) {
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $usersPdo = new UserPdo();
} catch (Exception $exception) {
    array_push($errors, LOGIN_FAILED);
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

$user = $usersPdo->getUserByEmail($loginRequest['email']);

if (empty($user)) {
    array_push($errors, 'Неверный логин');
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
} elseif (!password_verify($loginRequest['password'], $user['password_hash'])) {
    array_push($errors, 'Неверный пароль');
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

session_start();
$_SESSION["userId"] = $user['id'];
$_SESSION["userName"] = $user['name'];

echo json_encode(['success' => true]);
