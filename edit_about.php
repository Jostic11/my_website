<?
	$now_inf = R::findOne('aside_down', '`id` = ?', array(5));
	$b = false;
	$data = $_POST;
	
	if( isset($data['save'])){
		$errors = array();
		if(trim($data['title']) == ''){
			$errors[] = 'Название нельзя делать пустым';
		}

		if(empty($errors)){
			/*
			?>
			<script type="text/javascript">
				if(confirm("Вы уверены, что хотете сохранить изменения?")){
					<?
				*/
					$now_inf->name = trim($data['title']);
					$now_inf->text = $data['text'];
					R::store($now_inf);
					$b = true;
					/*
					?>
				}	
			</script>
			<?
			*/
		}
	}
	$now_inf = R::findOne('aside_down', '`id` = ?', array(5));
?>

<article>
	<form method="POST" class="edit_something">
	<?
		//echo '<textarea>' . $now_inf["name"] . '</textarea>';
		echo '<p>название: </p><input type="text" value="' . $now_inf["name"] . '" name="title"/>';
		echo '<p>текст: </p><textarea name="text" class="edit_menu">' . $now_inf["text"] . '</textarea>';
	?>
		<br /> <input class="mbut" type="submit" name="save" id="newtaskbut" value="Сохранить" />
		<div>
			<?php 
				if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
				else {
					if($b == true) echo '<div id="right"> Вы успешно сохранили изменения </div>' ;
				}
			?>
		</div>
	</form>
</article>