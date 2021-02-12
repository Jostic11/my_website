<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	/*print_r($arr); echo '</br>';
	print_r($url);
	*/
	$cont = R::findOne('contests', '`id` = ?', array($arr['contest_id']));
	$live_cont = R::findOne('contests', '`id` = ?', array($arr['live_contest_id']));

	require "templates/article.php";
	?>

	<table class="left" border="1" cellpadding = "5px" id="tasks_table">
		<?
			$tasks = R::find('live_contest_tasks', '`idcontest` = ? ORDER BY `point` DESC', array($arr['live_contest_id']));
			$j = 1;
			foreach ($tasks as $task) {
				$task2 = R::findOne('tasks', '`id` = ?', array($task['idtask']));
				echo '<tr>';

				echo '<td>' . $j++ . '</td>';
				echo '<td>' . '<a href="task?live_contest_id=' . $arr['live_contest_id'] . '&contest_id=' . $arr['contest_id'] . '&task_id=' . $task2["id"] . '">' . $task2['name_task'] . '</a>' . '</td>';
				//echo '<td width="10px">' . '&nbsp' . '</td>';
//---- points
				echo '</tr>';
			}
		?>	
	</table>
</article>