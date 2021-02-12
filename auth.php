<article>
	<form method="POST" id="authForm">

		<div class="regblock">
			<label title="Введите ваш логин" for="login"> Логин: </label>
			<input type="text" name="login" title="Введите ваш логин" id="login" placeholder="Логин" />
		</div>


		<div class="regblock">
			<label title="Введите ваш пароль" for="password"> Пароль: </label>
			<input type="password" name="password" title="Введите ваш пароль" id="password" placeholder="Пароль" />
		</div>
	
		<input type="submit" name="authbutton" id="authbutton" value="Войти" />

		<div class="regblock" id="wr">
			<?
				if(!empty($errors))echo '<div class="wrong">' . array_shift($errors) . '</div>';
				else {
					if($b == true)echo '<div id="right"> Вы успешно авторизировались </div>';
				}
			?>
		</div>

	</form>
	<span class="clear"></span>
</article>