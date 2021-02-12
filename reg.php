<?php
	$b = false;
	$data = $_POST;
	if( isset($data['regbutton'])){
		$errors = array();

		if( trim($data['name']) == ''){
			$errors[] = 'Введите имя';
		}

		if( trim($data['secondname']) == ''){
			$errors[] = 'Введите фамилию';
		}

		if( trim($data['login']) == ''){
			$errors[] = 'Введите логин';
		}

		if( $data['password1'] == ''){
			$errors[] = 'Введите пароль';
		}

		if( $data['password2'] != $data['password1']){
			$errors[] = 'Пароль повторно введен неправильно';
		}

		/*if( !$data['pol']){
			$errors[] = 'Введите пол';
		}

		if( trim($data['country']) == ''){
			$errors[] = 'Введите страну';
		}

		
		if( trim($data['region']) == ''){
			$errors[] = 'Введите регион';
		}		

		if( trim($data['city']) == ''){
			$errors[] = 'Введите Город';
		}

		if( trim($data['school']) == ''){
			$errors[] = 'Введите школу';
		}*/

		if( trim($data['class']) == ''){
			$errors[] = 'Введите класс';
		}
		/*
		if( trim($data['email']) == ''){
			$errors[] = 'Введите email';
		}

		if( R::count('users', "email = ?", array(
			$data['email']
		)) > 0){
			$errors[] = 'Пользователь с таким email уже существует';
		}
*/
		if( R::count('users', "login = ?", array(
			$data['login'])
		) > 0){
			$errors[] = 'Пользователь с таким логином уже существует';
		}

		if(empty($errors)){
			$user = R::xdispense('users');
			if($data['person'] == 'Пользователь')$user->access = 2;
			//if($data['person'] == 'Ученик')$user->access = 1;
			if($data['person'] == 'Администратор')$user->access = 3;
			$user->name = $data['name'];
			$user->secondname = $data['secondname'];
			$user->login = $data['login'];
			$user->password1 = password_hash($data['password1'], PASSWORD_DEFAULT);
			/*$user->password1 = $data['password1'];*/
			$user->country = $data['country'];
			$user->region = $data['region'];
			$user->city = $data['city'];
			$user->school = $data['school'];
			$user->class = $data['class'];
			$user->email = $data['email'];
			R::store($user);
			$b = true;
		}
	}
?>

<article>
	<form method="POST" id="regForm">
		<div class="regblock">
			<label title="Кем вы являетесь?" for="person"> Кем вы являетесь: </label>
			<select name="person">
				<!--<option> </option> -->
				<option>Пользователь </option>
				<!--<option> Ученик </option> -->
				<option>Администратор </option>
			</select>
		</div>

		<div class="regblock">
			<label title="Введите ваше имя" for="name"> *Имя: </label>
			<input type="text" name="name" title="Введите ваше имя" id="name" placeholder="Имя" value="<?php echo @$data['name'] ?>"  />
		</div>


		<div class="regblock">
			<label title="Введите вашу фамилию" for="secondname"> *Фамилия: </label>
			<input type="text" name="secondname" title="Введите вашу Фамилию" id="secondname" placeholder="Фамилия" value="<?php echo @$data['secondname'] ?>" />
		</div>

		<div class="regblock">
			<label title="Придумайте ваш логин" for="login"> *Логин: </label>
			<input type="text" name="login" title="Введите ваш логин" id="login" placeholder="Логин" value="<?php echo @$data['login'] ?>" />
		</div>

		<div class="regblock">
			<label title="Введите пароль" for="password1"> *Пароль: </label>
			<input type="password" name="password1" title="Введите пароль" id="password1" placeholder="Пароль" <?php echo @$data['password1'] ?> />
		</div>

		<div class="regblock">
			<label title="Повторите прароль" for="password2"> *Повторите пароль: </label>
			<input type="password" name="password2" title="Повторите пароль" id="password2" placeholder="Пароль" <?php echo @$data['password2'] ?> />
		</div>

		<!-- <div class="regblock">
			<span> Пол: </span>
		    <input name="pol" type="radio" value=""> <span> Ж </span>
		    <input name="pol" type="radio" value=""> <span> М </span>
		</div>  -->

		<!-- <div class="regblock">
			<label title="Введите дату вашего рождения" for="birthday"> День рождения: </label>
			<input type="date" name="birthday" />
		</div> -->

		<div class="regblock">
			<label title="Введите вашу страну" for="country"> Страна: </label>
			<input type="text" name="country" title="Введите вашу Страну" id="country" placeholder="Страна" value="<?php echo @$data['country'] ?>" />
		</div>

		<div class="regblock">
			<label title="Введите ваш регион" for="region"> Регион: </label>
			<input type="text" name="region" title="Введите ваш Регион" id="region" placeholder="Регион" value="<?php echo @$data['region'] ?>" />
		</div>

		<div class="regblock">
			<label title="Введите ваш город" for="city"> Город: </label>
			<input type="text" name="city" title="Введите ваш город" id="city" placeholder="Город"  value="<?php echo @$data['city'] ?>" />
		</div>

		<div class="regblock">
			<label title="Введите название вашей школы" for="school"> Школа: </label>
			<input type="text" name="school" title="Введите название вашей школы" id="school" placeholder="Школа" value="<?php echo @$data['school'] ?>" />
		</div>

		<div class="regblock">
			<label title="Введите ваш класс" for="class"> *Класс: </label>
			<input type="text" name="class" title="Введите ваш класс" id="class" placeholder="9 Б" value="<?php echo @$data['class'] ?>" />
		</div>

		<div class="regblock">
			<label title="Введите вашу почту" for="email"> Почта: </label>
			<input type="email" name="email" id="email" placeholder="name@mail.ru" value="<?php echo @$data['email'] ?>" />
		</div>
	
		<input type="submit" name="regbutton" id="regbutton" value="Зарегистрироваться" />
		<div class="regblock" id="wr">
			<?php 
				if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
				else {
					if($b == true) echo '<div id="right"> Вы успешно зарегистрировались </div>' ;
				}
			?>
		</div>
	</form>
	<span class="clear"></span>
</article>