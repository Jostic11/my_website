<?php
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
?>

<article>	
	<div id="news">
	<?
	$news = R::findOne('news_posted', '`id` = ?', array($arr['news_id']));
	echo '<h4 align="center">' . $news['title'] . '</h4>';
	echo '<p>' . $news['text'] . '</p>';
	?>
	</div>
	<? require "templates/news_author.php"; ?>
</article>