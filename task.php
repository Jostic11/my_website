<?
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	$task = R::findOne('tasks', '`id` = ?', array($arr['task_id']));
	$cont = R::findOne('contests', '`id` = ?', array($arr['contest_id']));
	$live_cont = R::findOne('live_contests', '`id` = ?', array($arr['live_contest_id']));

	//var_dump($_FILES);
	
	$data = $_POST;
	if(isset($data['subbut'])){
		if(!($task['long_ans'] || $task['files'])){
			if($task['type_answ'] == 1){
				$try = R::xdispense('try');
				$try->idperson = $_SESSION['id'];
				$try->idtask = $arr['task_id'];
				$all = R::findAll('typeansw1', '`task_id` = ?', array($arr['task_id']));
				$j = 0; $right = 0; $att = "";
				foreach ($all as $i) {
					if($data['ch'.$j])$att .= strval($j+1) . ' ';
					
					if($data['ch'.$j] && $i['torf'] == '1' || (!$data['ch'.$j]) && $i['torf'] == '0')
						$right++;
					
					/*
					if($data['ch'.$j] == 'on' && $i['torf'] == '1')
						$right++;
					*/
					$j++;
				}
				$try->val = $att;
				if($right == $j)$try->res = "AC";
				else $try->res = "WA";// . strval($j - $right) . " fault";
				$try->contest = $arr['live_contest_id'];

				$try->date = date("Y-m-d H:i:s", time());
				$try->nametask = $task['name_task'];
				R::store($try);
				
					$full = R::findOne('live_contest_tasks', '`idcontest` = ? AND `idtask` = ?', array($arr['live_contest_id'], $arr['task_id']));
					$attempts = R::count('try', '`idperson` = ? AND `idtask` = ? AND `contest` = ?', array($_SESSION['id'], $arr['task_id'], $arr['live_contest_id']));
					//print_r($arr['live_contest_id']);
					//$tim_start = strtotime($live_cont['date']);
					//$minut = intdiv((time() - $tim_start), 60);
					//$now_point = max(0, intdiv(($full['point'] - intdiv($full['point'], 250) * $minut), $j) *$right - ($attempts-1) * 50);
					$right_now = 0;
					if($try->res == 'AC')$right_now = 1;
					$now_point = $right_now * $full['point'];

					$us_point = R::findOne('contest_res', '`idcontest` = ? AND `idperson` = ? AND `idtask` = ?', array($arr['live_contest_id'], $_SESSION['id'], $arr['task_id']));
					$al_p = R::findOne('contest_res_all', '`idcontest` = ? AND `idperson` = ?', array($arr['live_contest_id'], $_SESSION['id']));
					$al_p->points -= $us_point->points;
					$al_p->points += $now_point;
					$us_point->points = $now_point;

					R::store($us_point);
					R::store($al_p);
			}
			if($task['type_answ'] == 2){
				$right_ans = R::findOne('typeansw2', '`task_id` = ?', array($arr['task_id']));

				$try = R::xdispense('try');
				$try->idperson = $_SESSION['id'];
				$try->idtask = $arr['task_id'];
				$try->val = $data['only_chislo'];
				if(trim($right_ans['correct']) == trim($data['only_chislo']))$try->res = "AC";
				else $try->res = "WA";
				$try->contest = $arr['live_contest_id'];
				$try->date = date("Y-m-d H:i:s", time());
				$try->nametask = $task['name_task'];
				R::store($try);

				$full = R::findOne('live_contest_tasks', '`idcontest` = ? AND `idtask` = ?', array($arr['live_contest_id'], $arr['task_id']));
				$attempts = R::count('try', '`idperson` = ? AND `idtask` = ? AND `contest` = ?', array($_SESSION['id'], $arr['task_id'], $arr['live_contest_id']));
				//$tim_start = strtotime($live_cont['date']);
				//$minut = intdiv((time() - $tim_start), 60);
				$right_now = 0;
				if(trim($right_ans['correct']) == trim($data['only_chislo']))$right_now = 1;
				//$now_point = $right_now * max(0, ($full['point'] - intdiv($full['point'], 250) * $minut) - ($attempts-1) * 50);
				$now_point = $right_now * $full['point'];

				$us_point = R::findOne('contest_res', '`idcontest` = ? AND `idperson` = ? AND `idtask` = ?', array($arr['live_contest_id'], $_SESSION['id'], $arr['task_id']));
				$al_p = R::findOne('contest_res_all', '`idcontest` = ? AND `idperson` = ?', array($arr['live_contest_id'], $_SESSION['id']));
				$al_p->points -= $us_point->points;
				$al_p->points += $now_point;
				$us_point->points = $now_point;

				R::store($us_point);
				R::store($al_p);
			}
		}
		else {
			if($task['type_answ'] == 1){
				$try = R::xdispense('try');
				$try->idperson = $_SESSION['id'];
				$try->idtask = $arr['task_id'];
				$all = R::findAll('typeansw1', '`task_id` = ?', array($arr['task_id']));
				$j = 0; $right = 0; $att = "";
				foreach ($all as $i) {
					if($data['ch'.$j])$att .= strval($j+1) . ' ';
					
					if($data['ch'.$j] && $i['torf'] == '1' || (!$data['ch'.$j]) && $i['torf'] == '0')
						$right++;
					/*
					if($data['ch'.$j] == 'on' && $i['torf'] == '1')
						$right++;
					*/
					$j++;
				}
				$try->val = $att;
				if($right == $j)$try->res = "loaded";
				else $try->res = "WA";// . strval($j - $right) . " fault";
				$temp2 = R::findOne('contest_res', '`idcontest` = ? AND `idperson` = ? AND `idtask` = ?', array($arr['live_contest_id'], $_SESSION['id'], $arr['task_id']));
				$temp2->loaded = 1;
				R::store($temp2);
				if($data['write_long_ans']){
					$try->text = $data['write_long_ans'];
				}
				$try->contest = $arr['live_contest_id'];
				$try->date = date("Y-m-d H:i:s", time());
				$try->nametask = $task['name_task'];
				$id_temp = R::store($try);
				if($_FILES['image']){
					$image_add = $_FILES['image'];
					$rename = mfrename($image_add['name'], $id_temp);
					$try2 = R::findOne('try', '`id` = ?', array($id_temp));
					$try2->file = 'uploads/' . $rename;
					R::store($try2);
					move_uploaded_file($image_add['tmp_name'], 'uploads/' . $rename);
				}
				if($try->res != "WA"){
					$to_check = R::xdispense('need_to_check');
					$to_check->idauthor = $live_cont['idauthor'];
					$to_check->try_id = $id_temp;
					$to_check->date = date("Y-m-d H:i:s", time());
					$to_check->login = $_SESSION['login'];
					$to_check->contest_name = $live_cont['name'];
					$to_check->task_name = $task['name_task'];
					$to_check->contest = $live_cont['id'];
					R::store($to_check);
				}
			}
			if($task['type_answ'] == 2){
				$right_ans = R::findOne('typeansw2', '`task_id` = ?', array($arr['task_id']));

				$try = R::xdispense('try');
				$try->idperson = $_SESSION['id'];
				$try->idtask = $arr['task_id'];
				$try->val = $data['only_chislo'];
				if(trim($right_ans['correct']) == trim($data['only_chislo']))$try->res = "loaded";
				else $try->res = "WA";
				$temp2 = R::findOne('contest_res', '`idcontest` = ? AND `idperson` = ? AND `idtask` = ?', array($arr['live_contest_id'], $_SESSION['id'], $arr['task_id']));
				$temp2->loaded = 1;
				R::store($temp2);
				if($data['write_long_ans']){
					$try->text = $data['write_long_ans'];
				}
				$try->contest = $arr['live_contest_id'];
				$try->date = date("Y-m-d H:i:s", time());
				$try->nametask = $task['name_task'];
				$id_temp = R::store($try);
				if($_FILES['image']){
					$image_add = $_FILES['image'];
					$rename = mfrename($image_add['name'], $id_temp);
					$try2 = R::findOne('try', '`id` = ?', array($id_temp));
					$try2->file = 'uploads/' . $rename;
					R::store($try2);
					move_uploaded_file($image_add['tmp_name'], 'uploads/' . $rename);
				}
				if($try->res != "WA"){
					$to_check = R::xdispense('need_to_check');
					$to_check->idauthor = $live_cont['idauthor'];
					$to_check->try_id = $id_temp;
					$to_check->date = date("Y-m-d H:i:s", time());
					$to_check->login = $_SESSION['login'];
					$to_check->contest_name = $live_cont['name'];
					$to_check->task_name = $task['name_task'];
					$to_check->contest = $live_cont['id'];
					R::store($to_check);
				}
			}
			if($task['type_answ'] == 3 || !$task['type_answ']){
				$try = R::xdispense('try');
				$try->idperson = $_SESSION['id'];
				$try->idtask = $arr['task_id'];
				$try->res = "loaded";
				$temp2 = R::findOne('contest_res', '`idcontest` = ? AND `idperson` = ? AND `idtask` = ?', array($arr['live_contest_id'], $_SESSION['id'], $arr['task_id']));
				$temp2->loaded = 1;
				R::store($temp2);
				if($data['write_long_ans']){
					$try->text = $data['write_long_ans'];
				}
				$try->contest = $arr['live_contest_id'];
				$try->date = date("Y-m-d H:i:s", time());
				$try->nametask = $task['name_task'];
				$id_temp = R::store($try);

				if($_FILES['image']){
					$image_add = $_FILES['image'];
					$rename = mfrename($image_add['name'], $id_temp);
					$try2 = R::findOne('try', '`id` = ?', array($id_temp));
					$try2->file = 'uploads/' . $rename;
					R::store($try2);
					move_uploaded_file($image_add['tmp_name'], 'uploads/' . $rename);
				}
				$to_check = R::xdispense('need_to_check');
				$to_check->idauthor = $live_cont['idauthor'];
				$to_check->try_id = $id_temp;
				$to_check->date = date("Y-m-d H:i:s", time());
				$to_check->login = $_SESSION['login'];
				$to_check->contest_name = $live_cont['name'];
				$to_check->task_name = $task['name_task'];
				$to_check->contest = $live_cont['id'];
				R::store($to_check);
			}
		}
	}
?>

<article>
	<?
		require "templates/article.php";
		$now = R::findOne('tasks', '`id` = ?', array($arr['task_id']));
		echo $now['name_task'] . '<br> <br>';
		echo nl2br($now['taskcondition']) . '<br> <br>';

		echo '<form method="POST" id="get_ans_for_task" enctype="multipart/form-data">';
		if($now['type_answ'] == 1){
			echo "Выберите только правильные ответы: <br> <br>";
			$all = R::findAll('typeansw1', '`task_id` = ?', array($arr['task_id']));
			$j = 0;
			foreach ($all as $i) {
				echo '</textarea> <input type="checkbox" name="ch'.$j++.'" /> ';
				echo $i['var_text'] . '<br>';
			}
		}
		if($now['type_answ'] == 2){
			//echo "Вписывайте ответ только цифрой без пробелов. Дробные числа пишите через точку: <br> <br>";
			echo '<input type="text" id="only_chislo" name="only_chislo" />';
			echo '<label for="only_chislo">Введите краткий ответ</label>';
		}
		if($now['long_ans']){
			echo '<br /><br /><textarea id="write_long_ans" name="write_long_ans"></textarea><br />';
		}
		if($now['files']){
			echo '<br /><br /><input type="file" id="image" name="image"> </input><br />';
		}
		echo '<br /> <input class="mbut" type="submit" name="subbut" id="subbut" value="Сдать задачу" />';
		echo '</form>';
	?>
	

</article>