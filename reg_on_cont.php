<?php
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);

	//print_r($arr);
	$b = false;
	$data = $_POST;
?>

<article>
	<div id="reg_rul">
		<h1> Правила соревнования: </h1>
		<?
		$temp_contest = R::findOne('live_contests', '`id` = ?', array($arr['live_contest_id']));
		echo $temp_contest['rules'];
		?>
	</div> <br/ >

	<form method="POST">
		<input type="checkbox" name="agree_rul"> Я согласен с правилами <br /> <br />
		<input type="submit" name="reg_on" value="Зарегистрироваться">
		<div class="regblock">
			<?
				//print_r($errors);
				if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
				else {
					if($b == true) echo '<div id="right"> Вы успешно зарегистрировались в контесте </div>' ;
				}
			?>
		</div>
	</form>
</article>