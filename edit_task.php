<?php
$url = $_SERVER['REQUEST_URI'];
$arr = mparse($url);
$bdtask = R::findOne('tasks', '`id` = ?', array($arr['id']));

$b = false;
$data = $_POST;
if( isset($data['save_task_but'])){
	$errors = array();
	if($data['condition'] == ''){
		$errors[] = 'Введите название задачи';
	}

	if($data['task'] == ''){
		$errors[] = 'Введите условие задачи';
	}
	if(empty($errors)){
		if($data['ask_answ'] == 1){
			$var_answ = array();
			$var_answ_ch = array();

			for($i=1; $i<=10; $i++){
				if(!empty(trim($data["ans1_text" . $i]))){
					$var_answ[] = $data["ans1_text" . $i];
				}
				else $var_answ[] = '';
			}

			$now = false;
			for($c=0; $c<count($var_answ); $c++){
				if(!empty(trim($var_answ[$c])))$now = true;
			}

			if(!$now){
				$errors[] = 'Введите хоть 1 вариант ответа';
			}

			for($i=1; $i<=10; $i++){
				if($data["ch". $i] != '')$var_answ_ch[] = true;
				else $var_answ_ch[] = false;
			}
			
			$kol = 0;
			for($c=0; $c < count($var_answ); $c++){
				if($var_answ_ch[$c] && empty(trim($var_answ[$c]))){
					$errors[] = 'вариант ответа №' + $c + 'не может быть правильным';
				}
				if($var_answ_ch[$c])$kol++;
			}

			if($kol == 0){
				$errors[] = 'нет ни одного правильного ответа';
			}

			if(empty($errors)){
				if($bdtask['type_answ'] == 2){
					$was_type = R::findOne('typeansw2', '`task_id` = ?', array($arr['id']));
					R::trash($was_type);
				}

				if($bdtask['type_answ'] == 1){
					$was = R::find('typeansw1', '`task_id` = ?', array($arr['id']));
					R::trashAll($was);
				}
				$newtask = R::findOne('tasks', '`id` = ?', array($arr['id']));
				$newtask->taskcondition = $data['task'];
				$newtask->name_task = $data['condition'];
				$newtask->type_answ = $data['ask_answ'];
				if($data['long_ans'])$newtask->long_ans = 1;
				else $newtask->long_ans = 0;
				if($data['file_ans'])$newtask->files = 1;
				else $newtask->files = 0;
				$id_our_task = R::store($newtask);

				for($c=0; $c < count($var_answ); $c++){
					if(!empty(trim($var_answ[$c]))){
						$newvar = R::xdispense('typeansw1');
						$newvar->task_id = $id_our_task;
						$newvar->var_text = $var_answ[$c];
						$newvar->torf = $var_answ_ch[$c];
						R::store($newvar);
					}
				}
				$b = true;
			}
		}
		if($data['ask_answ'] == 2){
			if($data['only_chislo'] == ''){
				$errors[] = 'Введите ответ на задачу';
			}

			if(empty($errors)){
				if($bdtask['type_answ'] == 2){
					$was_type = R::findOne('typeansw2', '`task_id` = ?', array($arr['id']));
					R::trash($was_type);
				}

				if($bdtask['type_answ'] == 1){
					$was = R::find('typeansw1', '`task_id` = ?', array($arr['id']));
					R::trashAll($was);
				}

				$newtask = R::findOne('tasks', '`id` = ?', array($arr['id']));
				$newtask->taskcondition = $data['task'];
				$newtask->name_task = $data['condition'];
				$newtask->type_answ = $data['ask_answ'];
				if($data['long_ans'])$newtask->long_ans = 1;
				else $newtask->long_ans = 0;
				if($data['file_ans'])$newtask->files = 1;
				else $newtask->files = 0;
				$id_our_task = R::store($newtask);

				$newvar =  R::xdispense('typeansw2');
				$newvar->task_id = $id_our_task;
				$newvar->correct = trim($data['only_chislo']);
				R::store($newvar);

				$b = true;
			}
		}
		if(!$data['ask_answ'] || $data['ask_answ'] == 3){
			if(!($data['long_ans'] || $data['file_ans'])){
				$errors[] = 'Введите хоть какой нибудь вариант ответа';
			}

			if(empty($errors)){
				if($bdtask['type_answ'] == 2){
					$was_type = R::findOne('typeansw2', '`task_id` = ?', array($arr['id']));
					R::trash($was_type);
				}

				if($bdtask['type_answ'] == 1){
					$was = R::find('typeansw1', '`task_id` = ?', array($arr['id']));
					R::trashAll($was);
				}

				$newtask = R::findOne('tasks', '`id` = ?', array($arr['id']));
				$newtask->taskcondition = $data['task'];
				$newtask->name_task = $data['condition'];
				$newtask->type_answ = $data['ask_answ'];
				if($data['long_ans'])$newtask->long_ans = 1;
				else $newtask->long_ans = 0;
				if($data['file_ans'])$newtask->files = 1;
				else $newtask->files = 0;
				$id_our_task = R::store($newtask);

				$b = true;
			}
		}
	}
}
$bdtask = R::findOne('tasks', '`id` = ?', array($arr['id']));
?>

<article>
	<div class="create">
		<a href="my_tasks" class="to_lists"> Перейти к моим задачам </a>
		<div class="right" id="list">
			<? //echo $GLOBALS['id']; ?>
		</div>

		<form id="taskadd" method="POST">
			<label for="condition"> Введите название задачи: </label>
			<input name="condition" type="text" id="condition" value="<?php echo $bdtask['name_task']; ?>" /> <br /><br /> 
			
			<label for="task"> Введите условие задачи: </label><br />
			<textarea name="task" id="task"><?php echo $bdtask['taskcondition']; ?></textarea> <br /><br />

			<p> Выберете способ ответа: </p> 
			
			<?echo "&nbsp&nbsp";?><input type="radio" name="ask_answ" id="ansType1" value="1"> <label for="ansType1"> X вариантов ответа. Y правильных. </label> <br />
			<?echo "&nbsp&nbsp";?><input type="radio" name="ask_answ" id="ansType2" value="2"> <label for="ansType2"> Ответ пишется самостоятельно </label> <br />
			<?echo "&nbsp&nbsp";?><input type="radio" name="ask_answ" id="ansType3" value="3"> <label for="ansType3"> Ничего из вышеперечисленного </label> <br />
			
			<script type="text/javascript">
					$("#ansType<?echo $bdtask['type_answ'];?>").attr("checked", true);
			</script>

			<p>Дополнительные возможности ответа: </p>
			<input type="checkbox" name="long_ans" id="long_ans"> <label for="long_ans"> Развернутый ответ, с проверкой вручную. </label> <br />
			<input type="checkbox" name="file_ans" id="file_ans"> <label for="file_ans"> Возможность прикреплять файл. </label> <br />

			<?if($bdtask['files']) {?>
			<script type="text/javascript">
					$("#file_ans").attr("checked", true);
			</script>
			<?}
			if($bdtask['long_ans']) {?>
			<script type="text/javascript">
					$("#long_ans").attr("checked", true);
			</script>
			<?}?>

			<div id="ans1">
				<?php
					$var_ans = R::find('typeansw1', '`task_id` = ?', array($arr['id']));
					$j = 1;
					foreach ($var_ans as $i) {
						echo '<span> Вариант ответа №', $j, ' </span>';
						echo '<textarea id="ans1_text'.$j.'" name="ans1_text'.$j.'">'. $i["var_text"]. '</textarea> <input type="checkbox" name="ch'. $j .'" id="ch'. $j .'"> Ответ верен? <br />';
						if($i["torf"]){
							?>
							<script type="text/javascript">
								$('#ch' + <? echo $j; ?>).prop('checked',true);
							</script>
							<?
						}	
						$j++;
					}
					for(; $j <= 10; $j++){
						echo '<span> Вариант ответа №', $j, ' </span>';
						echo '<textarea id="ans1_text'.$j.'" name="ans1_text'.$j.'"></textarea> <input type="checkbox" name="ch'. $j .'"> Ответ верен? <br />';	
					}
				?>
				<br />
				<h> все пустые варианты ответов будут проигнорированы </h>
			</div>

			<div id="ans2">
				<label for="only_chislo"> Введите правильный ответ </label> <br />
				<? $res_ans = R::findOne('typeansw2', '`task_id` = ?', array($arr['id'])); ?>
				<textarea id="only_chislo" name="only_chislo"><?echo$res_ans['correct'];?></textarea>
			</div>

			<br /> <input class="mbut" type="submit" name="save_task_but" id="save_task_but" value="Сохранить задачу задачу" />
			<div>
				<?php 
					if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
					else {
						if($b == true) echo '<div id="right"> Вы успешно сохранили задачу </div>' ;
					}
				?>
			</div>
		</form>
	
	</div>
	<span class="clear"></span>
</article>

