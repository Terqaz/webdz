<?php

include "pdo.php";

try {
    $web3kursPdo = DBConnect\getWeb3kursPdo();
} catch (Exception $exception) {
    echo "Ошибка подключения к БД: " . $exception->getMessage();
    exit;
}

$cardId = intval(@$_GET['id']);

if (!is_numeric($cardId) || $cardId == 0) {
    header('Location:/index.php');
    exit;
}

$sql = 'SELECT id, creation_date, url FROM screenshot 
		WHERE id = :cardId';

$screenshot = $web3kursPdo->prepare($sql);
$screenshot->bindValue(':cardId', $cardId, PDO::PARAM_STR);
$screenshot->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>

	<script src="js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="js/script.js" defer></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/detail.css">
</head>
<body>
	<div class="wrapper">
		<?php require_once 'parts\header.html'; ?>
		<main class="content">
			<div class="content__screenshot-wrapper">
				<?php if ($screenshot->rowCount() === 0):  ?>
					<p class="content__screenshot-description">Этот скриншот не найден :( </p>

				<?php else: ?>
				<?php $screenshot = $screenshot->fetch(PDO::FETCH_ASSOC) ?>
					<p class="content__screenshot-description">СКРИНШОТ ОТ <?= $screenshot['creation_date'] ?></p>
					<div class="screenshot__wrapper">
						<img src=<?= $screenshot['url'] ?> alt="" class="screenshot__wrapper__content">
					</div>
				<?php endif; ?>
			</div>
		</main>
		<?php require_once 'parts\footer.html'; ?>
	</div>
	<?php require_once 'parts\form.html'; ?>
</body>
</html>
