<article>
	<?
		$contests = R::findAll('live_contests', "ORDER BY `date` ASC");

		echo "<h4> Текущие события: </h4>";
		///echo "</br>";
		foreach ($contests as $i) {
			/*
			$preg = R::findOne('persons_take_part', '`idperson` = ? AND `idcontest` = ?', array(
				$_SESSION['id'],
				$i['id']
			));
			if(!empty($preg)){
				$dop = R::findOne('user_now_take_part', '`idperson` = ?', array($_SESSION['id']));
				if(!($dop)){
					$dd = R::xdispense('user_now_take_part');
					$dd->idperson = $_SESSION['id']; 
					$dd->idcontest = $i['idcontest'];
					R::store($dd);
				}
				else {
					$dop->idcontest = $i['idcontest'];
					//print_r($dop->idcontest);
					R::store($dop);
				}
			}*/
			
			$now_time = time();
			$time_contest = strtotime($i['date']);


			if($now_time > $time_contest + $i['duration']*60){
				$alr_end = R::xdispense('past_contests');
				$alr_end->idcontest = $i['idcontest'];
				$alr_end->name = $i['name'];
				$alr_end->date = $i['date'];
				$alr_end->duration = $i['duration'];
				$alr_end->live_contest_id = $i['id'];
				$alr_end->idauthor = $i['idauthor'];
				R::trash($i);
				R::store($alr_end);
				continue;
			}

			if($time_contest > $now_time)break;
			$ost = $now_time - $time_contest;
			
			echo "<div class='immediate_contests'> ";
			echo $i['name'], "<br />";
			echo "До окончания соревнования остается: ", date("H:i:s", mktime(0, 0, $i['duration']*60 - $ost)), "<br />";
			//print_r($preg);
			echo '<a href="monitor?live_contest_id=' . $i["id"] . '&contest_id=' . $i["idcontest"] . '"> текущие результаты </a>';
			$alr_reg = R::findOne('persons_take_part', '`idperson` = ? AND `idcontest` = ?', array($_SESSION['id'], $i['id']));
			if(empty($alr_reg))echo "<a href='reg_on_cont?live_contest_id=" . $i['id'] . "'> Зарегистрироваться на контест </a>";
			echo "</div> <br />";
			echo "</div>";
		}
		//echo '<br /><br /><br />';

		echo "<h4> Предстоящие события: </h4>";
		//echo '</br>';
		foreach ($contests as $i) {
			$now_time = time();
			$time_contest = strtotime($i['date']);

			//print_r($now_time); echo '</br>';
			//print_r($time_contest); echo '</br>';

			if($now_time >= $time_contest)continue;
			$ost = $time_contest - $now_time;

			echo "<div class='immediate_contests'> ";
			echo $i['name'], "<br />"; 
			echo "До начала остается: ";
			
			$days = intdiv($ost, 86400);
			if($days > 0)
				echo $days . "д ";
			
			echo date("H:i:s", mktime(0, 0, $ost)), "<br />";
			echo "<a href='contest?live_contest_id=" . $i['id'] . "&contest_id=" . $i['idcontest'] . "'> посмотреть участников </a>";
			$alr_reg = R::findOne('persons_take_part', '`idperson` = ? AND `idcontest` = ?', array($_SESSION['id'], $i['id']));
			if(empty($alr_reg))echo "<a href='reg_on_cont?live_contest_id=" . $i['id'] . "&contest_id=" . $i['idcontest'] . "'> Зарегистрироваться на контест </a>";
			echo "</div> <br />";

		}
	?>
</article>