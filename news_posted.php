<article>
	<h3 align="center"> Ваши новости, которые выложили на главную страницу </h3><br /><br />
	<?
		$posted_news = R::findCollection('news_posted', 'idauthor = ?', array($_SESSION['id']));
		while ($post = $posted_news->next()) {
			echo '<a href="news_page?news_id=' . $post["id"] .'">' . $post['title'] . '</a><br /><br />';
		}
	?>
</article>