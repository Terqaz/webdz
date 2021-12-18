<?php

require_once "phpclasses/pdo/UserPdo.php";
require_once "phpclasses/Validation.php";

const REGISTER_FAILED = 'Не удалось зарегистрировать нового пользователя. Попробуйте позже';

header('Content-Type: application/json');

$registerRequest = $_POST;

$registerRequest = array_map(
    function ($v) {
       return htmlspecialchars($v);
   },
    $registerRequest
);

$errors = Validation::validateRegisterRequest($registerRequest);

if (!empty($errors)) {
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $userPdo = new UserPdo();
} catch (Exception $exception) {
    array_push($errors, REGISTER_FAILED);
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($userPdo->isEmailExist($registerRequest['email'])) {
    array_push($errors, 'Данный email занят другим пользователем');
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $userId = $userPdo->save($registerRequest);
} catch (Exception $exception) {
    array_push($errors, REGISTER_FAILED);
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

session_start();
$_SESSION["userId"] = $userId;
$_SESSION["userName"] = $registerRequest['name'];

echo json_encode(['success' => true]);
