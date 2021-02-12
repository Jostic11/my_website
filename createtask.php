<?php
	$b = false;
	$data = $_POST;
	if( isset($data['newtaskbut'])){
		$errors = array();
		if($data['condition'] == ''){
			$errors[] = 'Введите название задачи.';
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
					$newtask = R::xdispense('tasks');
					$newtask->taskcondition = $data['task'];
					$newtask->name_task = $data['condition'];
					$newtask->type_answ = $data['ask_answ'];
					if($data['long_ans'])$newtask->long_ans = 1;
					if($data['file_ans'])$newtask->files = 1;
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

					$person = R::xdispense('task_maker');
					//$person->person_id = $user['id'];
					//$person->person_id = localStorage.getItem('id');
					$person->person_id = $_SESSION['id'];
					//$person->person_id = $GLOBALS['id'];
					$person->task_id = $id_our_task;
					R::store($person);

					$b = true;
				}
			}
			if($data['ask_answ'] == 2){
				if($data['only_chislo'] == ''){
					$errors[] = 'Введите ответ на задачу';
				}

				if(empty($errors)){
					$newtask = R::xdispense('tasks');
					$newtask->taskcondition = $data['task'];
					$newtask->name_task = $data['condition'];
					$newtask->type_answ = $data['ask_answ'];
					if($data['long_ans'])$newtask->long_ans = 1;
					if($data['file_ans'])$newtask->files = 1;
					$id_our_task = R::store($newtask);

					$newvar =  R::xdispense('typeansw2');
					$newvar->task_id = $id_our_task;
					$newvar->correct = $data['only_chislo'];
					R::store($newvar);

	            $person = R::xdispense('task_maker');
					$person->person_id = $_SESSION['id'];
					$person->task_id = $id_our_task;
					R::store($person);

					$b = true;
				}
			}
			if(!$data['ask_answ'] || $data['ask_answ'] == 3){
				if(!($data['long_ans'] || $data['file_ans'])){
					$errors[] = 'Введите хоть какой нибудь вариант ответа';
				}

				if(empty($errors)){
					$newtask = R::xdispense('tasks');
					$newtask->taskcondition = $data['task'];
					$newtask->name_task = $data['condition'];
					$newtask->type_answ = $data['ask_answ'];
					if($data['long_ans'])$newtask->long_ans = 1;
					if($data['file_ans'])$newtask->files = 1;
					$id_our_task = R::store($newtask);

	            $person = R::xdispense('task_maker');
					$person->person_id = $_SESSION['id'];
					$person->task_id = $id_our_task;
					R::store($person);

					$b = true;
				}
			}
		}
	}
?>

<article>
		<div class="create">
			<div class="right" id="list">
				<? //echo $GLOBALS['id']; ?>
			</div>

			<form id="taskadd" method="POST">
				<label for="condition"> Введите название задачи. Постарайтесь у каждой задачи в контесте сделать разные первые слова (в результатах отображается только первое слово из названия) </label>
				<input name="condition" type="text" id="condition" value="<?php echo @$data['condition']; ?>" /> <br /><br /> 
				
				<label for="task"> Введите условие задачи: </label><br />
				<textarea name="task" id="task"><?php echo @$data['task']; ?></textarea> <br /><br />

				<p> Выберете способ ответа: </p> 
				
				<?echo "&nbsp&nbsp";?><input type="radio" name="ask_answ" id="ansType1" value="1"> <label for="ansType1"> X вариантов ответа. Y правильных. </label> <br />
				<?echo "&nbsp&nbsp";?><input type="radio" name="ask_answ" id="ansType2" value="2"> <label for="ansType2"> Ответ пишется самостоятельно </label> <br />
				<?echo "&nbsp&nbsp";?><input type="radio" name="ask_answ" id="ansType3" value="3"> <label for="ansType3"> Ничего из вышеперечисленного </label> <br />
				<p>Дополнительные возможности ответа: </p>
				<input type="checkbox" name="long_ans" id="long_ans"> <label for="file_ans"> Развернутый ответ, с проверкой вручную. </label> <br />
				<input type="checkbox" name="file_ans" id="file_ans"> <label for="file_ans"> Возможность прикреплять файл. </label> <br />

				<div id="ans1">
					<?
						for($i=1; $i<=10; $i++){
							echo '<span> Вариант ответа №' . $i . '</span>';
							echo '<textarea id="ans1_text'. $i .'" name="ans1_text'. $i .'">', $data["ans1_text" . $i], '</textarea> <input type="checkbox" name="ch'.$i.'" /> Ответ верен? <br />';
						}
					?>
					
					<br />
					<h> все пустые варианты ответов будут проигнорированы </h>
				</div>

				<div id="ans2">
					<label for="only_chislo"> Введите правильный ответ </label> <br />
					<textarea id="only_chislo" name="only_chislo"></textarea>
				</div>

<!--
				<div id="ans3">

					<span class="now_pos"> 1 </span> <span> / </span> <span class="all_kol"> 1 </span> <br />
					<span> Введите букву к заданию №</span> <span class="now_pos"> 1 </span> <span> </span> <br />
					<textarea id="ans3_text"></textarea> 
					<p id='another_one' onclick='func1_plus1()'> + Добавить еще один вариант </p><br />
					<span onclick='func1_tobeg()' class='flip'> В начало </span>  
					<span onclick='func1_previous()' class='flip'> <= </span>  
					<span onclick='func1_next()' class='flip'> => </span>  
					<span onclick='func1_toend()' class='flip'> В конец </span>
				</div>
-->
				<br /> <input class="mbut" type="submit" name="newtaskbut" id="newtaskbut" value="Загрузить задачу" />
				<div>
					<?php 
						if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
						else {
							if($b == true) echo '<div id="right"> Вы успешно Добавили задачу </div>' ;
						}
					?>
				</div>
			</form>
		
		</div>
		<span class="clear"></span>
	</article>