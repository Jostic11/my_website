<div class="left" id="contest_top">
	<ul id="contest_top_ul">
		<li class="left"> 
			<a href="after_contest_tasks?past_contest_id=<? echo $arr['past_contest_id'];?>&contest_id=<? echo $arr['contest_id'];?>"> Задачи </a>
		</li>
		
		<li class="left"> 
			<a href="try_past?past_contest_id=<? echo $arr['past_contest_id'];?>&contest_id=<? echo $arr['contest_id'];?>"> Мои посылки </a>
		</li>

		<li class="left"> 
			<a href="results?past_contest_id=<? echo $arr['past_contest_id'];?>&contest_id=<? echo $arr['contest_id'];?>"> Положение </a>
		</li>
	</ul>
</div>

<div class="clear"></div>

<div class="right" id="contest_div">

	<div id="insight">
	<?
		$live_cont = R::findOne('past_contests', '`id` = ?', array($arr['past_contest_id']));
		$cont = R::findOne('contests', '`id` = ?', array($arr['contest_id']));
		
		echo $cont['name'] . '<br /><br />';
		echo 'Соревнование окончилось' . '<br />';
		$user = R::findOne('users', '`id` = ?', array($cont['author']));
		echo "Автор соревнования: " . $user['login'];
	?>
	</div>
</div>