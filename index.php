<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>

	<script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/script.js" defer></script>
	<script type="text/javascript" src="js/ajax-loading.js" defer></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="wrapper">
		<header class="header">
			<div class="header__wrapper">
				<a href="/" class="logo">SCREEN SHARE</a>
				<button class="auth-btn">Вход или регистрация</button>
			</div>
		</header>
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
		<footer class="footer">
			<div class="footer__wrapper">
				<p class="footer__wrapper__email">holinvova@gmail.com</p>
				<p class="footer__wrapper__name">Холин Владимир</p>
			</div>
		</footer>
	</div>
	<div class="mask"></div>
	<div class="modal__wrapper">
		<div class="modal__content">
			<div class="modal__content__auth modal__content__registration">
				<div class="modal-header">
				    <p class="modal-header__description">Зарегистрироваться</p>
				    <span class="modal__content__close">&times;</span>
				</div>	
			   	<div class="modal-body">
				    <form class="modal-body__form" id="regForm">
				    	<label class="form__label">Имя*</label>
				     	<input type="text" class="form__text-input" name="name" pattern="^([А-ЯЁ][а-яё-]{1,30}[\s]*)+$" required>

				     	<label class="form__label">E-mail*</label>
				     	<input type="email" class="form__text-input" name="email" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" required>

						<label class="form__label">Телефон*</label>
				     	<input type="text" class="form__text-input" name="phone" pattern="^\+*[0-9]{0,1}\({0,1}[0-9]{1,4}\){0,1}[-\s\.0-9]*$" required>

				     	<label class="form__label">Пароль*</label>
				     	<input type="password" class="form__text-input" name="password" minlength="6" placeholder="Придумайте пароль" required>

				     	<label class="form__label">Повторите пароль*</label>
				     	<input type="password" class="form__text-input" name="repeatPassword" placeholder="Повторите пароль"   required>

				     	<div class="form__agreement">
				     		<input type="checkbox" class="form__checkbox-input" name="agreeCheckbox" required> 
				     		<label class="form__agreement__label">Принимаю согласие на обработку персональных данных*</label>
				     	</div>

				     	<div class="g-recaptcha__wrapper">
				     		<div class="g-recaptcha" data-sitekey="6LdOQQodAAAAAAcUczjcCgzENgGd-_9uW1tYwg5s"></div>
				     	</div>

				     	<input type="submit" class="form__submit-btn" value="Зарегистрироваться">
				    </form>
			    </div>
			</div>
			<div class="modal__content__auth modal__content__login">
				<div class="modal-header">
				    <p class="modal-header__description">Войти</p>
				    <span class="modal__content__close">&times;</span>
				</div>	
			   	<div class="modal-body">
				    <form class="modal-body__form" id="loginForm" action="">
				    	<label class="form__label">E-mail*</label>
				     	<input type="email" class="form__text-input" name="email" pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" required>

				     	<label class="form__label">Пароль*</label>
				     	<input type="password" class="form__text-input" name="password" required>

				     	<div class="g-recaptcha__wrapper">
				     		<div class="g-recaptcha" data-sitekey="6LdOQQodAAAAAAcUczjcCgzENgGd-_9uW1tYwg5s"></div>
				     	</div>

				     	<input type="submit" class="form__submit-btn" value="Войти">
				    </form>
			    </div>
			</div>
			<div class="modal-footer">
				<button disabled class="modal-footer__btn modal-footer__to-registration-btn" disabled>Регистрация</button>
				<button class="modal-footer__btn modal-footer__to-login-btn">Логин</button>
			</div>

			<p class="form__error" id="formError">тест</p>
		</div>
	</div>
</body>
</html>
