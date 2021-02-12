<header>
	<a href="next" title="На главную" id="logo"><?echo $config['title'];?></a>
	<span class="contact">
		<a href="about" title="О нас" id="inf"> О нас </a>
	</span>
	<span class="right">
		<?php
			if(isset($_SESSION['login'])){
				?>
				<a class="contact" href="profile"> <?echo $_SESSION['login'];?> </a>
				<a class="contact" name="out" id="out" href="logout" onclick="return confirm('Вы уверены,что хотите выйти?')"> Выход </a>
				<?php
			}
			else {
				?>
				<span class="contact">
					<a href="auth" title="Вход"> Вход </a>
				</span>

				<span class="contact">
					<a href="reg" title="Регистрация"> Регистрация </a>
				</span>
				<?php
			}
		?>
	</span>

	<span class="clear"></span>
</header>