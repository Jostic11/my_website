<article>
	<?php
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	require "templates/article_past.php";
	?>
	<table class="left" border="1" cellpadding = "5px" id="tasks_table">
		<?
			echo '<tr>';
				echo '<td>' . '№' . '</td>';
				echo '<td>' . 'Кто' . '</td>';
				echo '<td>' . '=' . '</td>';
				$pastc = R::findOne('past_contests', '`id` = ?', array($arr['past_contest_id']));
				$len = R::findAll('live_contest_tasks', '`idcontest` = ?', array($pastc['live_contest_id']));
				foreach ($len as $ll) {
					echo '<td>' . mf($ll['task_name']) . '</td>';
					//echo '<td>' . $ll['task_name'] . '</td>';
				}
			echo '</tr>';
			
			$attempts = R::findAll('contest_res_all', '`idcontest` = ? ORDER BY `points` DESC', array($pastc['live_contest_id']));
			$j = 1;
			foreach ($attempts as $attempt) {
				echo '<tr>';

				echo '<td>' . $j++ . '</td>';
				echo '<td>' . $attempt['login'] . '</td>';
				echo '<td>' . $attempt['points'] . '</td>';

				$tasks_res = R::findAll('contest_res', '`idperson` = ? AND `idcontest` = ? ORDER BY `task_name` ASC', array($attempt['idperson'], $pastc['live_contest_id']));

				foreach ($tasks_res as $task_res) {
					if($task_res['loaded'])echo '<td> ? </td>';
					else echo '<td>' . $task_res['points'] . '</td>';
				}

				echo '</tr>';
			}
		?>	
	</table>
</article>