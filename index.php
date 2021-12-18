<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>

	<?php if (!isset($_SESSION['userName'])):  ?>
		<script type="text/javascript" src="js/not-logged-user.js" defer></script>
	<?php else:  ?>
		<script type="text/javascript" src="js/logged-user.js" defer></script>
	<?php endif; ?>

	<script type="text/javascript" src="js/ajax-loading.js" defer></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="wrapper">
	 	<?php require_once 'parts/header.html'; ?>	
		<main class="content">
			<div class="content__wrapper">
				<p class="content__description">ПОСЛЕДНИЕ СКРИНШОТЫ</p>
				<div class="content__wrapper__rows">
					
					<div class="autoscroll-trigger" id="autoscroll-trigger">
						<img class="autoscroll-trigger__gif" src="resources/loading.gif" alt="">
					</div>
				</div>
			</div>
		</main>
		<?php require_once 'parts/footer.html'; ?>
	</div>
</body>
</html>
