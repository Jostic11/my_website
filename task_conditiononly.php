<?
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	$task = R::findOne('tasks', '`id` = ?', array($arr['task_id']));
	$cont = R::findOne('contests', '`id` = ?', array($arr['contest_id']));
	$past_cont = R::findOne('past_contests', '`id` = ?', array($arr['past_contest_id']));

	$data = $_POST;
	if(isset($data['subbut'])){
		if($task['type_answ'] == 1){
			$try = R::xdispense('try');
			$try->idperson = $_SESSION['id'];
			$try->idtask = $arr['task_id'];
			$all = R::findAll('typeansw1', '`task_id` = ?', array($arr['task_id']));
			$j = 0; $right = 0; $att = "";
			foreach ($all as $i) {
				if($data['ch'.$j])$att .= strval($j+1) . ' ';
				/*
				if($data['ch'.$j] == 'on' && $i['torf'] == '1' || $data['ch'.$j] == '' && $i['torf'] == '0')
					$right++;
				*/
				if($data['ch'.$j] == 'on' && $i['torf'] == '1')
					$right++;
				$j++;
			}
			//temp j
			$j = 1;
			$try->val = $att;
			if($right == $j)$try->res = "AC";
			else $try->res = "WA " . strval($j - $right) . " fault";
			$try->contest = $arr['past_contest_id'];

			$try->date = date("Y-m-d H:i:s", time());
			$try->nametask = $task['name_task'];
			R::store($try);
			
			$full = R::findOne('live_contest_tasks', '`idcontest` = ? AND `idtask` = ?', array($arr['past_contest_id'], $arr['task_id']));
			$attempts = R::count('try', '`idperson` = ? AND `idtask` = ? AND `contest` = ?', array($_SESSION['id'], $arr['task_id'], $arr['past_contest_id']));
			//print_r($arr['live_contest_id']);
			$tim_start = strtotime($past_cont['date']);
			$minut = intdiv((time() - $tim_start), 60);
			$now_point = max(0, intdiv(($full['point'] - intdiv($full['point'], 250) * $minut), $j) *$right - ($attempts-1) * 50);
			
			$us_point = R::findOne('contest_res', '`idcontest` = ? AND `idperson` = ? AND `idtask` = ?', array($arr['past_contest_id'], $_SESSION['id'], $arr['task_id']));
			$al_p = R::findOne('contest_res_all', '`idcontest` = ? AND `idperson` = ?', array($arr['past_contest_id'], $_SESSION['id']));
			$al_p->points -= $us_point->points;
			$al_p->points += $now_point;
			$us_point->points = $now_point;

			R::store($us_point);
			R::store($al_p);
		}
	}
?>

<article>
	<?
		require "templates/article_past.php";
		$now = R::findOne('tasks', '`id` = ?', array($arr['task_id']));
		echo $now['name_task'] . '<br> <br>';
		echo nl2br($now['taskcondition']) . '<br> <br>';

		if($now['type_answ'] == 1){
			echo "Выберите как можно больше правильных ответов из предложеных: <br> <br>";
			$all = R::findAll('typeansw1', '`task_id` = ?', array($arr['task_id']));
			$j = 0;
			foreach ($all as $i) {
				echo '</textarea> <input type="checkbox" name="ch'.$j++.'" /> ';
				echo $i['var_text'] . '<br>';
			}
		}
		
	?>
	

</article>