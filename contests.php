<?
	$b = false;
	$data = $_POST;
	$check = R::find('contests', "`author` = ?", array($_SESSION['id']));
	foreach ($check as $i) {
		if(isset($data['kaka'. $i['id']])){
			$errors = false;

			if(!$data['date'. $i['id']]){
				$errors[] = true;
				?>
				<script type="text/javascript">
					alert('Введите дату соревнования');
				</script>
				<?
				break;
			}

			if(!$data['time'. $i['id']]){
				$errors[] = true;
				?>
				<script type="text/javascript">
					alert('Введите время соревнования');
				</script>
				<?
				break;
			}

			if(!$errors){
				$contest = R::xdispense('live_contests');
				$contest->idcontest = $i['id'];
				$contest->name = $i['name'];
				$arr = getdate(strtotime($data['date'. $i['id']]));
				$arr2 = getdate(strtotime($data['time'. $i['id']]));
				$be_time = mktime($arr2['hours'], $arr2['minutes'], $arr2['seconds'], $arr['mon'], $arr['mday'], $arr['year']);
				$contest->date = date("Y-m-d H:i:s", $be_time);
				$contest->idauthor = $_SESSION['id'];
				R::store($contest);
				$b = true;
			}

			break;
		}

	}
?>

<article>
	<?
	$contests = R::find('contests', "`author` = ?", array($_SESSION['id']));
	foreach ($contests as $i) {
		echo $i['name'], "<br />";
		?>
		<form id="personcontest" method="POST">
			<?
			echo "<label> Время начала соревнования: </label>";
			echo "<input type='date' id= 'date", $i['id'], "'  name='date", $i['id'], "' />";
			echo "<input type='time' id= 'time", $i['id'], "'  name='time", $i['id'], "' />"; 
			echo "<input class='mbut' type='submit' name='kaka", $i['id'], "' value='Запустить контест'  id='kaka", $i['id'], "' />"; 
			?>
		</form>
		<br /><br />
	<?
	} 
	?>
</article>