<?php
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	$bdinf = R::findOne('news_rejected', '`id` = ?', array($arr['news_id']));

	$b = false;
	$data = $_POST;
	if( isset($data['new_news'])){
		$errors = array();

		if(trim($data['title_news']) == ''){
			$errors[] = 'Введите заголовок новости! В последствии вы сможете поменять его.';
		}

		if(trim($data['text_news']) == ''){
			$errors[] = 'Введите текст новости! В последствии вы сможете поменять его.';
		}

		if(empty($errors)){
			//$news = R::findOne('news_offered', '`id` = ?', array($arr['news_id']));
			$news = R::xdispense('news_offered');
			$news->title = $data['title_news'];
			$news->idauthor = $_SESSION['id'];
			$news->author = $_SESSION['login'];
			//$temp = mktime($arr2['hours'], $arr2['minutes'], $arr2['seconds'], $arr['mon'], $arr['mday'], $arr['year']);
			//$contest2->date = date("Y-m-d H:i:s", $be_time);

			//$a = getdate(time());
			//$news->date = $a;
			$news->text = $data['text_news'];
			R::store($news);
			R::trash($bdinf);
			$b = true;
			$bdinf = $news;
		}
	}
	//$bdinf = R::findOne('news_rejected', '`id` = ?', array($arr['news_id']));
?>

<article>
		<div class="create">
			<form id="createnews" method="POST">
				<div id="create_news_div">
					<label for="title_news"> Заголовок новости </label>
					<input type="text" id="title_news" name="title_news" value="<? if($bdinf)echo $bdinf['title']; ?>"> <br /> <br />

					<label for="text_news"> Текст новости: </label><br />
					<textarea name="text_news" id="text_news"><? if($bdinf)echo $bdinf['text']; ?></textarea> <br /><br />
				</div>

				<div class="left">
					<br /> <input class="mbut" type="submit" name="new_news" id="new_news" value="Предложить новость повторно" />
					<div>
						<?php 
							if(!empty($errors)) echo '<div class="wrong">' . array_shift($errors) . '</div>' ;
							else {
								if($b == true) echo '<div id="right"> Вы успешно предложили новость повторно </div>' ;
							}
						?>
					</div>
				</div>
			</form>
		
		</div>
		<span class="clear"></span>
	</article>