<article>
	<h4> Мои результаты: </h4>
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
				if(strtotime($contest['date']) > time())continue;
				echo '<tr>';

				$allinf = R::findOne('past_contests', '`live_contest_id` = ?', array($contest['idcontest']));
				//echo '<td>' . $j++ . '</td>';
				echo '<td>' . $allinf['name'] . '</td>';
				echo '<td>' . $contest['points'] . '</td>';
				echo '<td>' . $contest['position'] . '</td>';

				echo '</tr>';
			}

		?>	
	</table>
</article>