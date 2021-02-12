<?
	$data = $_POST;
	$pcont = R::findCollection('contests', '`author` = ?', array($_SESSION['id']));
	
	while ($now_cont = $pcont->next()) {
		if( isset($data['newcont' . $now_cont["id"]])){
			/*$alredy = R::find('live_contests', '`idcontest` = ?', array($now_cont["id"]));
			if(!empty($alredy)){
				?>
				<script type="text/javascript">
					alert('этот контест уже запущен');
				</script>
				<?
				break;
			}*/
			/*
			if(trim($data['name_contest']) == ''){
				?>
				<script type="text/javascript">
					alert('введите название соревнования');
				</script>
				<?
				break;
			}*/

			if(!$data['contestDate' . $now_cont["id"]] || !$data['contestTime' . $now_cont["id"]] || !$data['contestLen' . $now_cont["id"]]){
				?>
				<script type="text/javascript">
					alert('Введите дату, время начала соревнования и длину самого соревнования в минутах');
				</script>
				<?
				break;
			}

			if(!$data['contest_rules' . $now_cont["id"]]){
				?>
				<script type="text/javascript">
					alert('Введите правила соревнования');
				</script>
				<?
				break;
			}

			if(strlen($data['contestLen' . $now_cont["id"]]) > 8){
				?>
				<script type="text/javascript">
					alert('время контеста очень большое');
				</script>
				<?
				break;
			}

			if(!is_int($data['contestLen' . $now_cont["id"]])){
				?>
				<script type="text/javascript">
					alert('время контеста не является числом');
				</script>
				<?
				break;
			}

			$contest2 = R::xdispense('live_contests');

			$arr = getdate(strtotime($data['contestDate' . $now_cont["id"]]));
			$arr2 = getdate(strtotime($data['contestTime' . $now_cont["id"]]));
			$be_time = mktime($arr2['hours'], $arr2['minutes'], $arr2['seconds'], $arr['mon'], $arr['mday'], $arr['year']);
			$contest2->date = date("Y-m-d H:i:s", $be_time);
			$contest2->duration = $data['contestLen' . $now_cont["id"]];
			$contest2->name = $now_cont["name"];
			$contest2->idcontest = $now_cont['id'];
			$contest2->idauthor = $_SESSION['id'];
			$contest2->rules = $data['contest_rules' . $now_cont["id"]];
			
			R::store($contest2);

			$all_tasks = R::findAll('contest_tasks', '`idcontest` = ?', array($now_cont["id"]));
			foreach ($all_tasks as $task) {
				$nnew1 = R::xdispense('live_contest_tasks');
				$nnew1->idcontest = $contest2->id;
				$nnew1->idtask = $task->idtask;
				$nnew1->point = $task->point;
				$nnew1->task_name = $task->task_name;
				R::store($nnew1);
			}

			$contest3 = R::findOne('contests', '`id` = ?', array($now_cont['id']));
			$contest3->date = $contest2->date;
			R::store($contest3);
			break;
		}
	}
?>

<article>
	<h4> Мои контесты: </h4>
	<?php
	$pcont = R::findCollection('contests', '`author` = ? ORDER BY `DATE` DESC', array($_SESSION['id']));
	while ($now_cont = $pcont->next()) {
		echo '<div class="my_cont">';
			

		/*
			echo '<div class="my_cont">';
			//echo $now_cont['name'] . '<br />';
			echo '<a href="edit_contests?id=' . $now_cont["id"] . '">' . $now_cont["name"] . '<br />';
			echo '</div>';
		*/

 

			echo '<a href="edit_contests?id=' . $now_cont["id"] . '">' . $now_cont["name"] . '</a><br />';
			echo '<form method="POST">';
				echo '<label> Время начала (мск): </label>';
				echo '<input type="date" id="contestDate' . $now_cont["id"] . '" name="contestDate' . $now_cont["id"] . '" />';
				echo '<input type="time" id="contestTime' . $now_cont["id"] . '" name="contestTime' . $now_cont["id"] . '" />'; 
				echo 'длительность(мин):';
				echo  '<input type="textbox" name="contestLen' . $now_cont["id"] . '" />';
				echo '<input type="submit" value="Добавить контест" class="mbut" name="newcont' . $now_cont['id'] . '" />';
				echo '<br />Введите правила соревнования, если хотите запустить его!';
				echo '<textarea name="contest_rules' . $now_cont["id"] . '" id="contest_rules"></textarea>';
			echo '</form>';
		echo '</div>';
	}
	?>
</article>