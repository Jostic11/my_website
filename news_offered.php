<article>
	<h3 align="center"> Ваши новости, которые находятся в очереди </h3><br /><br />
	<?
		$posted_news = R::findCollection('news_offered', 'idauthor = ?', array($_SESSION['id']));
		while ($post = $posted_news->next()) {
			echo '<a href="edit_news?news_id=' . $post["id"] .'">' . $post['title'] . '</a><br /><br />';
		}
	?>
</article>