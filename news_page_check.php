<?
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	$news = R::findOne('news_offered', '`id` = ?', array($arr['news_id']));
?>

<article>	
	<div id="news">
	<?
	echo '<h4 align="center">' . $news['title'] . '</h4>';
	echo '<p>' . $news['text'] . '</p>';
	?>
	</div>
	<? require "templates/news_author.php"; ?>
</article>