<?
	$data = $_POST;
	$contests = R::findAll('past_contests', "ORDER BY `date` DESC");
	foreach ($contests as $contest2) {
		if(isset($data['reset_res' . $contest2['live_contest_id']])){
			$attempts = R::findAll('contest_res_all', '`idcontest` = ? ORDER BY `points` DESC', array($contest2['live_contest_id']));
			$j = 0;
			foreach ($attempts as $attempt) {
				$j++;
				$attempt->position = $j;
				R::store($attempt);
			}
			break;
		}
	}
?>

<article>
	<h4> Прошедшие соревнования: </h4>
	<?php
	//$contests = R::findAll('past_contests', "ORDER BY `date` DESC");
	foreach ($contests as $contest) {
		$now_time = time();
		$time_contest = strtotime($contest['date']);
		$ost = $time_contest - $now_time;
		if($ost + $contest['duration']*60 < 0){
			echo "<div class='immediate_contests'> ";
			echo $contest['name'], "<br />"; 
			//echo "<a href='monitor?id=" . $contest['id'] . "'> Результаты </a>";
			echo "<a href='results?past_contest_id=" . $contest['id'] . "&contest_id=" . $contest['idcontest'] . "'> Результаты </a>";
			if($_SESSION['access'] >= 3){
				echo '<form method="POST" class="right">';
				echo "<input type='submit' class='mbut' value='Перерасчитать результаты' name='reset_res" . $contest['live_contest_id'] . "'>";
				echo '</form>';
			}
			echo "</div> <br />";
		}
	}
	?>
</article>