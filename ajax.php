<?php

require_once "phpclasses/pdo/ScreenshotPdo.php";
require_once "phpclasses/Validation.php";

$lastId = @$_GET['lastid'];

if ($lastId != 0 && !Validation::checkId($lastId)) {
    header('Location: /index.php');
    exit;
}

try {
    $screenshotPdo = new ScreenshotPdo();
} catch (Exception $exception) {
    echo "Fatal error: " . $exception->getMessage();
    exit;
}

$screenshots = $screenshotPdo->getScreenshots($lastId, 10);

if ($screenshots->rowCount() !== 0): ?>
	<?php while ($screenshot = $screenshots->fetch(PDO::FETCH_ASSOC)): ?>
		<div  class="screenshot-card" data-id=<?= $screenshot['id'] ?> onclick="location.href='<?= '/detail.php?id='.$screenshot['id'] ?>';">
			<div class="screenshot-card__image-wrapper">
				<img src=<?= $screenshot['url'] ?> alt="" class="screenshot-card__image-wrapper__content">
			</div>
			<p>Опубликовано</p>
			<p class="screenshot-card__date">
				<?= $screenshot['creation_date'] ?></p>
		</div>
	<?php endwhile; ?>

<?php endif; ?>