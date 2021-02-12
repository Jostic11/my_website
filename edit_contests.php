<?php
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	//$bdcont = R::findOne('contests', '`id` = ?', array($arr['id']));

	$b = false;
	$data = $_POST;
	if(isset($data['newcont'])){
		$errors = array();

		if(trim($data['name_contest']) == ''){
			$errors[] = 'Нельзя делать пустое название.';
		}

		$all_person_task = R::find('task_maker', "`person_id` = ?", array($_SESSION['id']));
		$tasks_id = array();
		foreach ($all_person_task as $i) {
			$tasks_id[] = $i['task_id'];
		}
		
		$one = false;
		foreach ($tasks_id as $i) {
			if($data[$i]){
				$one = true;
				if(!is_numeric($data["point" . $i])){
					$errors[] = 'Количество баллов должно быть числом';
				}
			}
		}
		if($one == false){
			$errors[] = 'Добавте хотя бы одну задачу в соревнование';
		}

		if(empty($errors)){
			$all_contest_task_was = R::findAll('contest_tasks', "`idcontest` = ?", array($arr['id']));
			R::trashAll($all_contest_task_was);

			$contest = R::findOne('contests', "`id` = ?", array($arr['id']));
			$contest->name = $data['name_contest'];
			R::store($contest);

			foreach ($tasks_id as $i) {
				if($data[$i]){
					$tt = R::xdispense('contest_tasks');
					//$tt->idcontest = $cont_id;
					$tt->idcontest = $arr['id'];
					$tt->idtask = $i;
					$tt->point = $data['point'.$i];
					$name2 = R::findOne('tasks', '`id` = ?', array($i));
					$tt->task_name = $name2['name_task'];
					R::store($tt);
				}
			}
			
			$b = true;
			
		}
	}

	$bdcont = R::findOne('contests', '`id` = ?', array($arr['id']));
?>

<article>
		<div class="create">
			<form id="createcont" method="POST">

				<a href="my_contests" class="to_lists"> Перейти к моим контестам </a>

				<div>
					<label for="name_contest"> Введите название контеста </label>
					<input type="text" id="name_contest" name="name_contest" value="<?php echo $bdcont['name']; ?>" /> <br /> <br />
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
						//echo $arr['id'];
						$all_contest_task = R::findCollection('contest_tasks', "`idcontest` = ?", array($arr['id']));
						//$all_contest_task = $all_contest_task->export();
						//echo $arr['id'];
						$use = array();

						while ($now_task = $all_contest_task->next()) {
							//if(!$all_contest_task[$j+1])echo "fuck";
							//echo '<pre>'; echo print_r($all_contest_task); echo '</pre>';
							$temp_task = R::findOne('tasks', '`id` = ?', array($now_task["idtask"]));
							//if(!$temp_task)echo "fuck";
							//echo $temp_task['name_task'];
							//print_r($now_task);
							echo "<input type='checkbox' id='", $temp_task["id"], "' name='", $temp_task["id"], "' class='butcc' checked='true'>", $temp_task['name_task'], '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Введите баллы за задачу: ';
							echo '<input type="textbox" class="points" name="point' . $temp_task["id"] . '" value="' . $now_task["point"] . '"></br>';
							//<input type='checkbox' name="ch3">
							$use[] = $temp_task['id'];
						}

						//print_r($use);

						$all_person_task2 = R::getAll("SELECT * FROM `tasks` WHERE `id` IN(".R::genSlots($tasks_id).")", $tasks_id);
						//$all_person_task2 = R::find('tasks', ' id IN ('.R::genSlots($tasks_id).')', $tasks_id);
						for($j=0; $j<count($all_person_task2); $j++){
							//echo ;
							$b2 = false;
							foreach ($use as $i) {
								//print_r($i);
								if($i == $all_person_task2[$j]['id']){
									$b2 = true;
									//echo "fuck";
								}
							}
							if($b2)continue;

							echo "<input type='checkbox' id='", $tasks_id[$j], "' name='", $tasks_id[$j], "' class='butcc'>", $all_person_task2[$j]['name_task'], '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Введите баллы за задачу: ';
							/*
							if($i["torf"]){
								?>
								<script type="text/javascript">
									$('#ch' + <? echo $j; ?>).prop('checked',true);
								</script>
								<?
							}
							*/	
							echo '<input type="textbox" class="points" name="point', $tasks_id[$j], '" ></br>';
							//<input type='checkbox' name="ch3">
						}

					}

					?>
					<br /> <input class="mbut" type="submit" name="newcont" id="newcont" value="Сохранить изменения" />
					<div>
						<?php 
							if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
							else {
								if($b == true) echo '<div id="right"> Вы успешно сохранили изменения </div>' ;
							}
						?>
					</div>
				</div>
			</form>
		
		</div>
		<span class="clear"></span>
	</article>