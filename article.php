<div class="left" id="contest_top">
	<ul id="contest_top_ul">
		<li class="left"> 
			<a href="contest_tasks?live_contest_id=<? echo $arr['live_contest_id'];?>&contest_id=<? echo $arr['contest_id'];?>"> Задачи </a>
		</li>
		
		<li class="left"> 
			<a href="try?live_contest_id=<? echo $arr['live_contest_id'];?>&contest_id=<? echo $arr['contest_id'];?>"> Мои посылки </a>
		</li>

		<li class="left"> 
			<a href="monitor?live_contest_id=<? echo $arr['live_contest_id'];?>&contest_id=<? echo $arr['contest_id'];?>"> Положение </a>
		</li>
	</ul>
</div>

<div class="clear"></div>

<div class="right" id="contest_div">

	<div id="insight">
	<?
		$live_cont = R::findOne('live_contests', '`id` = ?', array($arr['live_contest_id']));
		$cont = R::findOne('contests', '`id` = ?', array($arr['contest_id']));
		
		echo $cont['name'] . '<br /><br />';
		$now_time = time();
		$time_contest = strtotime($live_cont['date']);
		$ost = $live_cont['duration'] * 60 - ($now_time - $time_contest);
		echo "До окончания соревнования остается: ", date("H:i:s", mktime(0, 0, $ost)), "<br />";
		$user = R::findOne('users', '`id` = ?', array($cont['author']));
		echo "Автор соревнования: " . $user['login'];
	?>
	</div>
</div>