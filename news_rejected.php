<article>
	<h3 align="center"> Ваши новости, которые не одобрены </h3><br /><br />
	<?
		$posted_news = R::findCollection('news_rejected', 'idauthor = ?', array($_SESSION['id']));
		while ($post = $posted_news->next()) {
			echo '<a href="edit_news_rejected?news_id=' . $post["id"] .'">' . $post['title'] . '</a><br /><br />';
		}
	?>
</article>