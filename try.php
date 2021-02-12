<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	require "templates/article.php";
	?>
	<table class="left" border="1" cellpadding = "5px" id="tasks_table">
		<?
			$attempts = R::findAll('try', '`idperson` = ? AND `contest` = ? ORDER BY `date` DESC', array($_SESSION['id'], $arr['live_contest_id']));
			$j = 1;
			foreach ($attempts as $attempt) {
				echo '<tr>';

				echo '<td>' . $j++ . '</td>';
				echo '<td>' . $attempt['date'] . '</td>';
				echo '<td>' . $_SESSION['login'] . '</td>';
				echo '<td>' . $attempt['nametask'] . '</td>';
				echo '<td>' . $attempt['res'] . '</td>';

				echo '</tr>';
			}
		?>
	</table>
</article>