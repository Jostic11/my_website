<div id="news_author">
	<span> <? echo "Автор: " . $news['author']; ?> </span>
	<? if($news['date']) { ?>
		<span class="right"> <? echo "Выложено: " . $news['date']; ?> </span>
	<?} else {
		?>
		<form class="right" method="POST">
			<input type="submit" name="not_approve" class="mbut" value="Отклонить новость">
			<input type="submit" name="approve" class="mbut" value="Выложить новость на главную страницу" />
		</form>
		<?
	}
	?>
</div>