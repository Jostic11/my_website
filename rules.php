<article>
	<h4> <?
	$temp = R::findOne('aside_down', '`id` = 3');
	echo $temp['name'] . ":";
	?>
	</h4>

	<div>
		<? 
		$rules = R::findOne('aside_down', '`id` = 3');
		echo $rules['text'];
		?>
	</div>
</article>