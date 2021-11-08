<?php

// function console_log( $data ){
//   echo '<script>';
//   echo 'console.log('. json_encode( $data ) .')';
//   echo '</script>';
// }

$pdoConfig = parse_ini_file('.\\config\\pdo.ini');

try {
	$web3kursPdo = new PDO(
		'mysql:host='.$pdoConfig['host'].';dbname='.$pdoConfig['dbname'], 
		$pdoConfig['login'], 
		$pdoConfig['password'], 
		array( PDO::ATTR_PERSISTENT => true));
} catch (PDOException $exception) {
	echo "Ошибка подключения к БД: " . $exception->getMessage();
	exit;
}

$isPrivate = 0;
$limit = 10;
$lastId = intval(@$_GET['lastid']);

$sql = null;

if (is_numeric($lastId) && $lastId != 0) {
	$sql = 'SELECT id, creation_date, url FROM screenshot 
			WHERE id < :lastId && is_private=:isPrivate
			ORDER BY id DESC 
			LIMIT :lim';
	$screenshots = $web3kursPdo->prepare($sql);
	$screenshots->bindValue(':lastId', $lastId, PDO::PARAM_STR);

} else {
	$sql = 'SELECT id, creation_date, url FROM screenshot 
			WHERE is_private=:isPrivate
			ORDER BY id DESC 
			LIMIT :lim';
	$screenshots = $web3kursPdo->prepare($sql);
}

$screenshots->bindValue(':isPrivate', $isPrivate, PDO::PARAM_BOOL);
$screenshots->bindValue(':lim', $limit, PDO::PARAM_INT);

$screenshots->execute();			

if ($screenshots->rowCount() === 0): ?>
	<div class="stop-scroll"></div>

<?php else: ?>
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