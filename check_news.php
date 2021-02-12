<?
	$b = false;
	$data = $_POST;
	if(isset($data['get_author'])){
		$b = true;
	}
?>

<article>
	<form method="POST">
		Введите никнейм автора:
		<input type="text" name="handle"></input>
		<input type="submit" class="mbut" name="get_author" value="Применить">
		<input type="submit" class="mbut" name="del_author" value="Сбросить">
	</form><br /><br />
	<?
	if($b){
		$all = R::findCollection('news_offered', '`author` = ? ORDER BY `id` DESC', array($data['handle']));
	}
	else {
		$all = R::findCollection('news_offered', 'ORDER BY `id` DESC');
	}
	while ($now = $all->next()) {
		echo "<div class='checking_tasks'>";
		echo '<a class="ask_check_href" href="news_page_check?news_id=' . $now["id"] . '">' . $now["auth"] . "&nbsp&nbsp&nbsp&nbsp" . $now['title'] . '</a>';
		echo "</div>";
}
	?>
</article>