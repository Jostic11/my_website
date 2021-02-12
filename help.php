<article>
	<h4> <?
	$temp = R::findOne('aside_down', '`id` = 4');
	echo $temp['name'] . ":";
	?>
	</h4>

	<div>
		<? 
		$help = R::findOne('aside_down', '`id` = 4');
		echo $help['text'];
		?>
	</div>
</article>