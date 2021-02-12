<?php
	$b = false;
	$data = $_POST;
	if( isset($data['newcont'])){
		$errors = array();

		if(trim($data['name_contest']) == ''){
			$errors[] = 'Введите название соревнования! В последствии вы сможете поменять название.';
		}

		if(!$data['checktime'] && (!$data['contestDate'] || !$data['contestTime'] || !$data['contestLen'] || !$data['contest_rules'])){
			$errors[] = 'Введите дату, время начала соревнования и правила';
		}
		if(empty($errors)){
			if(!$data['checktime']){
				if(strlen($data['contestLen']) > 8){
					$errors[] = 'время контеста очень большое';
				}

				if(!is_int($data['contestLen'])){
					$errors[] = 'время контеста не является числом';
				}
			}

			$all_person_task = R::find('task_maker', "`person_id` = ?", array($_SESSION['id']));
			$tasks_id = array();
			foreach ($all_person_task as $i) {
				$tasks_id[] = $i['task_id'];
			}

			//print_r($tasks_id);

			$one = false;
			foreach ($tasks_id as $i) {
				if($data[$i]){
					$one = true;
					if(!is_numeric($data['point'.$i])){
						$errors[] = 'Количество баллов должно быть числом';
					}
				}
			}
			if($one == false){
				$errors[] = 'Добавте хотя бы одну задачу в соревнование';
			}


			if(empty($errors)){
				$contest = R::xdispense('contests');
				$contest->name = $data['name_contest'];
				$contest->author = $_SESSION['id'];
				$contest->date = date("Y-m-d H:i:s", time());
				R::store($contest);
				
				foreach ($tasks_id as $i) {
					if($data[$i]){
						
						$tt = R::xdispense('contest_tasks');
						//$tt->idcontest = $cont_id;
						$tt->idcontest = $contest->id;
						$tt->idtask = $i;
						$tt->point = $data['point'.$i];
						$name2 = R::findOne('tasks', '`id` = ?', array($i));
						$tt->task_name = $name2['name_task'];
						R::store($tt);
							
					}
				}
				

				if(!$data['checktime']){
					$contest2 = R::xdispense('live_contests');

					$arr = getdate(strtotime($data['contestDate']));
					$arr2 = getdate(strtotime($data['contestTime']));
					$be_time = mktime($arr2['hours'], $arr2['minutes'], $arr2['seconds'], $arr['mon'], $arr['mday'], $arr['year']);
					$contest2->date = date("Y-m-d H:i:s", $be_time);
					$contest2->duration = $data['contestLen'];

					$contest2->name = $data['name_contest'];
					$contest2->idcontest = $contest->id;
					$contest2->idauthor = $_SESSION['id'];
					$contest2->rules = $data['contest_rules'];
					R::store($contest2);

					foreach ($tasks_id as $i) {
						if($data[$i]){
							$tt = R::xdispense('live_contest_tasks');
							$tt->idcontest = $contest2->id;
							$tt->idtask = $i;
							$tt->point = $data['point'.$i];
							$name2 = R::findOne('tasks', '`id` = ?', array($i));
							$tt->task_name = $name2['name_task']; 
							R::store($tt);
						}
					}
				}
				
				$b = true;
			}
		}
	}
?>

<article>
		<div class="create">
			<form id="createcont" method="POST">
				<div>
					<label for="name_contest"> Введите название контеста </label>
					<input type="text" id="name_contest" name="name_contest"> <br /> <br />
					<div class="contest_border">
						<label> Время начала соревнования (мск): </label>
						<input type="date" id="contestDate" name="contestDate" /> 
						<input type="time" id="contestTime" name="contestTime" /> 
						и длительность соревнования(мин):
						<input type="textbox" name="contestLen"> <br /><br />
						Введите правила соревнования, если хотите сразу запустить его!
						<textarea name="contest_rules" id="contest_rules"></textarea>
					</div>

					<span> <pre>  или  </pre> </span>
					<div class="contest_border">
						<input type="checkbox" id="checktime" name="checktime"> <label for="checktime"> Пока только сохранить </label><br /><br /> <br /> 
					</div>
				</div>

				<div class="left" id="list">
					<?php
					echo "Выберете задачи из вашего списка задач:<br /><br />";
					$all_person_task = R::find('task_maker', "`person_id` = ?", array($_SESSION['id']));
					$tasks_id = array();
					foreach ($all_person_task as $i) {
						$tasks_id[] = $i['task_id'];
					}

					if(empty($tasks_id)){
						echo "У вас нет задач <br />";
					}
					else {
						$all_person_task2 = R::getAll("SELECT * FROM `tasks` WHERE `id` IN(".R::genSlots($tasks_id).")", $tasks_id);
						//$all_person_task2 = R::find('tasks', ' id IN ('.R::genSlots($tasks_id).')', $tasks_id);
						for($j=0; $j<count($all_person_task2); $j++){
							//echo ;
							echo "<input type='checkbox' id='", $tasks_id[$j], "' name='", $tasks_id[$j], "' class='butcc'>", $all_person_task2[$j]['name_task'], '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Введите баллы за задачу: ';
							echo '<input type="textbox" class="points" name="point', $tasks_id[$j], '" ></br>';
							//<input type='checkbox' name="ch3">
						}
					}

					?>
					<br /> <input class="mbut" type="submit" name="newcont" id="newcont" value="Добавить контест" />
					<div>
						<?php 
							if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
							else {
								if($b == true) echo '<div id="right"> Вы успешно создали контест </div>' ;
							}
						?>
					</div>
				</div>
			</form>
		
		</div>
		<span class="clear"></span>
	</article>