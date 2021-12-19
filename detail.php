<?php

require_once "phpclasses/pdo/ScreenshotPdo.php";
require_once "phpclasses/Validation.php";

session_start();

$screenshotId = @$_GET['id'];

if (!Validation::checkId($screenshotId)) {
    header('Location: /index.php');
    exit;
}

try {
    $screenshotPdo = new ScreenshotPdo();
} catch (Exception $exception) {
    echo "Fatal error: " . $exception->getMessage();
    exit;
}

$screenshot = $screenshotPdo->getScreenshot($screenshotId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="resources/favicon.png" type="image/x-icon">
	<title>Скриншот</title>

	<script src="js/jquery-3.6.0.min.js"></script>

	<?php if (!isset($_SESSION['userName'])):  ?>
		<script type="text/javascript" src="js/not-logged-user.js" defer></script>
	<?php else:  ?>
		<script type="text/javascript" src="js/logged-user.js" defer></script>
	<?php endif; ?>

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/detail.css">
</head>
<body>
	<div class="wrapper">
		<?php require_once 'parts/header.html'; ?>
		<main class="content">
			<div class="content__screenshot-wrapper">
				<?php if ($screenshot->rowCount() === 0):  ?>
					<p class="content__screenshot-description">Cкриншот не найден :( </p>

				<?php else: ?>
				<?php $screenshot = $screenshot->fetch(PDO::FETCH_ASSOC) ?>
					<p class="content__screenshot-description">СКРИНШОТ ОТ <?= $screenshot['creation_date'] ?></p>
					<div class="screenshot__wrapper">
						<img src=<?= $screenshot['url'] ?> alt="" class="screenshot__wrapper__content">
					</div>
				<?php endif; ?>
			</div>
		</main>
		<?php require_once 'parts/footer.html'; ?>
	</div>
</body>
</html>
