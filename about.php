<article>
	<h4> <?
	$temp = R::findOne('aside_down', '`id` = 5');
	echo $temp['name'] . ":";
	?>
	</h4>

	<div>
		<? 
		$about = R::findOne('aside_down', '`id` = 5');
		echo $about['text'];
		?>
	</div>
</article>