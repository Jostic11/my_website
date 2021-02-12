<article>
	<?php 
	
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	require "templates/article.php";
	$particip = R::find('persons_take_part', '`idcontest` = ?', array($arr['live_contest_id']));
	echo '<table id="the_part">';
	//print_r($particip);
	$j = 0;
	foreach ($particip as $i) {
		$j++;
		echo '<tr>';
		echo '<td>' . $j . '</td>';
		echo '<td>' . $i['name_person'] . '</td>';
		echo '</tr>';
	}

	echo '</table>';
	?>
</article>