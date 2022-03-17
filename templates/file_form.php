<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="resources/favicon.png" type="image/x-icon">
	<title>Загрузить скриншот</title>

	<?php if ($params['session']->has('userName')): ?>
		<script type="text/javascript" src="js/logged-user.js" defer></script>
		<script type="text/javascript" src="js/load_file.js" defer></script>
	<?php else:  ?>
		<script type="text/javascript" src="js/not-logged-user.js" defer></script>
	<?php endif; ?>

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/load_file.css">
</head>
<body>
	<div class="wrapper">
		<?php require_once 'parts/header.html'; ?>
		<main class="content">
			<?php if ($params['session']->has('userName')): ?>
				<form name="file" class="form form-file-loading" id="fileForm" method="post" enctype="multipart/form-data">

				    <div class="input__wrapper">
				       <input name="file" type="file" name="file" id="inputFile" class="input input__file" accept=".jpg, .jpeg, .png" required>
				       <label for="inputFile" class="input__file-button">
				          <span class="input__file-icon-wrapper"><img class="input__file-icon" src="resources/load_file.svg" alt="" width="25"></span>
				          <div id="inputFileBtn" class="input__file-button-text">Выберите файл</div>
				       </label>
				    </div>
				    <label class="file__format-text">*PNG или JPEG. Размер не более 3 МБ</label>
 
				    <div class="form__checkbox-wrapper">
			     	 	<input type="checkbox" class="form__checkbox-input" name="isPrivate"> 
			     	 	<label class="form__label">Доступен только по прямой ссылке</label>
			     	</div>

			     	<div class="g-recaptcha__wrapper file-form__g-recaptcha__wrapper">
			     		<div class="g-recaptcha" data-sitekey="6LdOQQodAAAAAAcUczjcCgzENgGd-_9uW1tYwg5s"></div>
			     	</div>

				    <input id="loadFileSubmitBtn" type="submit" name="submit" class="form__submit-btn" value="Загрузить скриншот">
				</form>

			<?php else: ?>
				<p class="content__screenshot-loading-description">Сначала необходимо авторизоваться</p>

			<?php endif; ?>
		</main>
		<?php require_once 'parts/footer.html'; ?>
	</div>
	<p class="form__error" id="formError"></p>
</body>
</html>
