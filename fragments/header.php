<header class="header">
	<div class="header__wrapper">
		<a href="/" class="logo">SCREEN SHARE</a>
		<?php if (!$params['session']->has('userName')):  ?>
			<button class="auth-btn">Вход или регистрация</button>

		<?php else:  ?>
			<p class="header__hello-user">Привет, <?= $params['session']->has('userName') ?></p>
			<button id="loadFileBtn" class="header__load-file-btn">Загрузить скриншот</button>
			<button id="exitBtn">Выход</button>

		<?php endif; ?>
	</div>
	
	<?php if (!$params['session']->has('userName')) {
		require_once __DIR__ . '/form.html';
	}?>
</header>
