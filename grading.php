<?
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);

	$try_inf = R::findOne('try', '`id` = ?', array($arr['try_id']));
	$task_live_inf = R::findOne('live_contest_tasks', '`idcontest` = ? && `idtask` = ?', array($try_inf['contest'], $try_inf['idtask']));


	$b = false;
	$data = $_POST; 
	if(isset($data['new_points'])){
		$errors = array();

		if(!ctype_digit(trim($data['res_point']))){
			$errors[] = 'Результат проверки может быть лишь целым числом';
		}
		else {
			if((int)trim($data['res_point']) > $task_live_inf['point']){
				$errors[] = 'Максимальный балл за задачу не может превышать ' . $task_live_inf['point'];
			}
		}

		if(empty($errors)){
			$res_task = R::findOne('contest_res', '`idcontest` = ? && `idtask` = ?', array($try_inf['contest'], $try_inf['idtask']));
			$res_all = R::findOne('contest_res_all', '`idcontest` = ?', array($try_inf['contest']));
			$res_all->points += (int)trim($data['res_point']);
			$res_all->points -= $res_task['points'];
			R::store($res_all);
		
			$res_task->points = (int)trim($data['res_point']);
			$res_task->loaded = 0;
			R::store($res_task);
			$b = true;

			$try_inf->res = (int)trim($data['res_point']);
			R::store($try_inf);

			$checked_task_edit = R::findOne('need_to_check', '`try_id` = ?', array($arr['try_id']));
			$checked_task_edit->checked = 1;
			R::store($checked_task_edit);
		}
	}
?>

<article>
	<?
	echo '<p align="center">' . $try_inf["nametask"] . '</p>'; 
	if($try_inf['text'])echo '<textarea id="checking_ans_text">' . $try_inf['text'] . '</textarea><br /><br />';
	if($try_inf['file'] && $try_inf['file']){
		echo '<a id="file_d" download href="' . $try_inf['file'] . '">' . 'Скачать файл с решением' . '</a>';
	}
	echo '<br /><br />';
	echo '<p> Оценка решения: </p>';
	echo '<form method="POST">';
	echo 'Решение оценено на <input type="text" name="res_point" id="res_point"></input> баллов из <b>' . $task_live_inf["point"] . '</b><br />';
	?>
	<br /> <input class="mbut" type="submit" name="new_points" id="new_points" value="Сохранить баллы" />
	<div>
		<?php 
			if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
			else {
				if($b == true) echo '<div id="right"> Вы успешно Сохранили баллы </div>' ;
			}
		?>
	</div>
	</form>
</article>