<?
	$b = false;
	$data = $_POST;
	/*
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	*/
	if(isset($data['del_filters'])){
		$b = false;
	}

	if(isset($data['save_filters'])){
		if($data['filter_sort'] == 1){
			if($data['alr_checked']){
				if($data['which_cont']){
					$all_was = R::findCollection('need_to_check', '`idauthor` = ? && `contest` = ? ORDER BY `date` DESC', array($_SESSION['id'], $data['which_cont']));
				}
				else $all_was = R::findCollection('need_to_check', '`idauthor` = ? ORDER BY `date` DESC', array($_SESSION['id']));
			}
			else {
				if($data['which_cont']){
					$all_was = R::findCollection('need_to_check', '`idauthor` = ? && `checked` = ? && `contest` = ? ORDER BY `date` DESC', array($_SESSION['id'], 0, $data['which_cont']));
				}
				else {
					$all_was = R::findCollection('need_to_check', '`idauthor` = ? && `checked` = ? ORDER BY `date` DESC', array($_SESSION['id'], 0));
				}
			}
		}
		else {
			if($data['alr_checked']){
				if($data['which_cont']){
					$all_was = R::findCollection('need_to_check', '`idauthor` = ? && `contest` = ? ORDER BY `date` ASC', array($_SESSION['id'], $data['which_cont']));
				}
				else $all_was = R::findCollection('need_to_check', '`idauthor` = ? ORDER BY `date` ASC', array($_SESSION['id']));
			}
			else {
				if($data['which_cont']){
					$all_was = R::findCollection('need_to_check', '`idauthor` = ? && `checked` = ? && `contest` = ? ORDER BY `date` ASC', array($_SESSION['id'], 0, $data['which_cont']));
				}
				else {
					$all_was = R::findCollection('need_to_check', '`idauthor` = ? && `checked` = ? ORDER BY `date` ASC', array($_SESSION['id'], 0));
				}
			}
		}

		$b = true;
	}
?>

<article>
	<div class="left"> 
		<?
		if(!$b){
			$all = R::findCollection('need_to_check', '`idauthor` = ? ORDER BY `date` DESC', array($_SESSION['id']));
			while ($now = $all->next()) {
				if($now['checked'])continue;
				echo "<div class='checking_tasks'>";
				echo '<a class="ask_check_href" href="grading?try_id=' . $now["try_id"] . '">' . $now["contest_name"] . "&nbsp&nbsp&nbsp&nbsp" . $now['task_name'] . "&nbsp&nbsp&nbsp&nbsp" . $now["login"] . '</a>';
				echo "</div>";
			}
		}
		else {
			while ($now = $all_was->next()) {
				echo "<div class='checking_tasks'>";
				echo '<a class="ask_check_href" href="grading?try_id=' . $now["try_id"] . '">' . $now["contest_name"] . "&nbsp&nbsp&nbsp&nbsp" . $now['task_name'] . "&nbsp&nbsp&nbsp&nbsp" . $now["login"] . '</a>';
				echo "</div>";
			}
		}
		?>
	</div>

	<form  class="right" id="check_filters" method="POST">
		<br /> <input class="mbut" type="submit" name="del_filters" id="del_filters" value="сбросить фильтры" />
		<p> Выберете контест: </p>
		<select name="which_cont">
			<option value="0"> Все </option>
			<?
			$person_contests = R::findCollection('live_contests', '`idauthor` = ?', array($_SESSION['id']));
			while ($contest = $person_contests->next()) {
				echo '<option value="' . $contest['id'] . '">' . $contest['name'] . '</option>';
			}
			$person_contests_past = R::findCollection('past_contests', '`idauthor` = ?', array($_SESSION['id']));
			while ($contest = $person_contests_past->next()) {
				echo '<option value="' . $contest['id'] . '">' . $contest['name'] . '</option>';
			}
			?>
		</select>
		<br /><br />
		<!--
		<input type="checkbox" name="file"> В решении используется файл с решением </input><br />
		<input type="checkbox" name="long_ans"> В решении используется развернутый ответ </input><br /><br />
		-->
		<span> Сортировать: </span>
		<select name="filter_sort">
			<option value="1"> сначала новые </option>
			<option value="2"> сначала старые </option>
		</select>
		<br /><br />
		<input type="checkbox" name="alr_checked"> Показывать уже проверенные </input><br /><br />

		<br /> <input class="mbut" type="submit" name="save_filters" id="save_filters" value="Применить фильтры" />
		<div>
			<?php 
				if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
				else {
					if($b == true) echo '<div id="right"> Фильтры были применены </div>' ;
				}
			?>
		</div>
	</form>
</article>