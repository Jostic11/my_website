<?
	$data = $_POST;
	$news = R::findCollection('news_posted', 'ORDER BY `date` DESC');
	
	while ($new = $news->next()) {
		if(isset($data['del_news' . $new['id']])){
			$del_new = R::xdispense('news_rejected');
			$del_new->title = $new->title;
			$del_new->text = $new->text;
			$del_new->author = $new->author;
			$del_new->idauthor = $new->idauthor;
			R::store($del_new);
			R::trash($new);
			break;
		}
	}
	$news = R::findCollection('news_posted', 'ORDER BY `date` DESC');
?>

<article>
	
	<h4> Новости: </h4>
	<?
	for($i=0; $i<20; $i++){
		$item = $news->next();
		if(!$item)break;
		?>
		<div class="topleft">
			<div class="blogdiv">
				<span class="blog">
					<? echo $item['title'] ?>
				</span>
			</div>
			<?
			echo '<a href="news_page?news_id=' . $item['id'] . '" title="Читать далее" class="blogbutton">';
				echo "Читать далее";
			echo "</a>";
			if($_SESSION['access'] >= 3){
				echo '<form method="POST">';
				echo '<input class="blogbutton" type="submit" name="del_news' . $item['id'] . '" id="del_news' . $item['id'] . '" value="Удалить новость" />';
				echo '</form>';
			}
			?>
		</div>
		<?
	}
	?>
</article>