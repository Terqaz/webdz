<?php while ($screenshot = $params['screenshots']->fetch(PDO::FETCH_ASSOC)): ?>
	<div class="screenshot-card" data-id=<?= $screenshot['id'] ?> onclick="location.href='<?= '/detail.php?id='.$screenshot['id'] ?>';">
		<div class="screenshot-card__image-wrapper">
			<img src=<?= $screenshot['url'] ?> alt="" class="screenshot-card__image-wrapper__content">
		</div>
		<p>Опубликовано</p>
		<p class="screenshot-card__date">
			<?= $screenshot['creation_date'] ?></p>
	</div>
<?php endwhile; ?>
