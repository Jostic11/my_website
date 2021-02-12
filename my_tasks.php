<?
	$data = $_POST;
	$pcont = R::findCollection('contests', '`author` = ?', array($_SESSION['id']));
	
	while ($now_cont = $pcont->next()) {
		if( isset($data['newcont' . $now_cont["id"]])){
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
			
			R::store($contest2);
			break;
		}
	}
?>

<article>
	<h4> Мои задачи: </h4>
	<?php
	$all_person_task = R::find('task_maker', "`person_id` = ?", array($_SESSION['id']));
	$tasks_id = array();
	foreach ($all_person_task as $i) {
		$tasks_id[] = $i['task_id'];
	}
	if(!empty($tasks_id)){
		$all_person_task2 = R::getAll("SELECT * FROM `tasks` WHERE `id` IN(".R::genSlots($tasks_id).") ORDER BY `id` DESC", $tasks_id);
		for($j=0; $j<count($all_person_task2); $j++){
			echo '<div class="my_cont">';
				echo $all_person_task2[$j]['name_task'], '<br />';
				echo '<a href="edit_task?id=' . $all_person_task2[$j]["id"] . '"> редактировать задачу </a>';
			echo '</div>';
		}
	}
	?>
</article>