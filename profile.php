<article>
	<div id="person_result_monitor">
		<a href="my_results" class="menu"> Мои результаты:</a>


		<table class="left" border="1" cellpadding = "5px" id="tasks_table">
		<?
			echo '<tr>';
				echo '<td>' . 'Соревнование' . '</td>';
				echo '<td>' . 'Баллы' . '</td>';
				echo '<td>' . 'Место' . '</td>';
			echo '</tr>';

			$contests = R::findAll('contest_res_all', '`idperson` = ? ORDER BY `date` DESC', array($_SESSION['id']));
			$j = 1;
			foreach ($contests as $contest) {
				if(!$contest['position'])continue;
				echo '<tr>';
				if($j++ > 1)break;
				//$allinf = R::findOne('past_contests', '`id` = ?', array($contest['idcontest']));
				//echo '<td>' . $j++ . '</td>';
				echo '<td>' . $contest['contest_name'] . '</td>';
				echo '<td>' . $contest['points'] . '</td>';
				echo '<td>' . $contest['position'] . '</td>';

				echo '</tr>';
			}

		?>	
		</table>
		<a href="my_results" class="left"> Еще результаты </a>
	</div>

	<div id="person_posts">
		<span class="menu"> Мои Новости:</span><br /><br />
		<a href="news_posted"> Выложенные новости:</a><br /><br />
		<a href="news_offered"> Предложенные новости:</a><br /><br />
		<a href="news_rejected"> Отклоненные новости:</a>
	</div>

	<div class="person_result">
		<a href="my_contests" class="menu"> Мои контесты: </a> <br /> <br />
		<?php
		$pcont = R::findCollection('contests', '`author` = ? ORDER BY `DATE` DESC', array($_SESSION['id']));
		$j = 0;
		while ($now_cont = $pcont->next()) {
			$j++;

			echo '<div class="my_cont">';
			//echo $now_cont['name'] . '<br />';
			echo '<a href="edit_contests?id=' . $now_cont["id"] . '">' . $now_cont["name"] . '<br />';
			echo '</div>';

			if($j == 3)break;
		}

		echo '<a href="my_contests"> перейти ко всем контестам </a>';
		?>
	</div>

	<div class="person_result">
		<a href="my_tasks" class="menu"> Мои задачи: </a> <br /> <br />
		<?php
		$all_person_task = R::find('task_maker', "`person_id` = ?", array($_SESSION['id']));
		$tasks_id = array();
		foreach ($all_person_task as $i) {
			$tasks_id[] = $i['task_id'];
		}
		if(!empty($tasks_id)){
			$all_person_task2 = R::getAll("SELECT * FROM `tasks` WHERE `id` IN(".R::genSlots($tasks_id).")  ORDER BY `id` DESC", $tasks_id);
			for($j=0; $j<min(count($all_person_task2), 3); $j++){
				echo '<div class="my_cont">';
					echo '<a href="edit_task?id=' . $all_person_task2[$j]["id"] . '">' . $all_person_task2[$j]['name_task'] . '<br />';
				echo '</div>';
			}
		}

		echo '<a href="my_tasks"> перейти ко всем задачам </a>';
		?>
	</div> 
</article>