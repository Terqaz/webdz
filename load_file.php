<?php


require_once "phpclasses/Validation.php";
require_once "phpclasses/pdo/ScreenshotPdo.php";

const UPLOAD_DIR = '/img/';

session_start();

if (!isset($_SESSION['userName'])) {
    header('Location: /index.php');
    exit;
}

$isPrivate = $_POST['isPrivate'] != 'false';
$file = $_FILES['file'];

if ($file['error'] != UPLOAD_ERR_OK) {
    echo json_encode(['errors' => "Ошибка загрузки файла: ".$error], JSON_UNESCAPED_UNICODE);
    exit;
}

$errors = Validation::validateFile($file);
if (!empty($errors)) {
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $screenshotPdo = new ScreenshotPdo();
} catch (Exception $exception) {
    echo "Fatal error: " . $exception->getMessage();
    exit;
}

$tmpName = $file["tmp_name"];

$extension = pathinfo($file['name'])['extension'] ?? "";
$newRelativePath = UPLOAD_DIR.uniqid().'.'.$extension;

if (!move_uploaded_file($tmpName, $_SERVER['DOCUMENT_ROOT'].$newRelativePath)) {
    echo json_encode(['errors' => "Ошибка перемещения файла"], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'success' => true,
    'id' => $screenshotPdo->save($newRelativePath, $isPrivate)]);
