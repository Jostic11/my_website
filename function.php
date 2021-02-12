<?php

function mparse($s) {
	$len = strlen($s);
	$last_name = '';
	$last_val = '';
	$arr = array();
	$now = -1;
	//echo '<br />';
	for($i=0; $i<$len; $i++){
		//print_r($last_name);
		//echo '<br />';
		if($s[$i] == '?' || $s[$i] == '&'){
			if($now != -1)$arr += [$last_name => $last_val];
			$last_name = '';
			$last_val = '';
			$now = 1;
		}
		else {
			if($now == -1)continue;
			if($s[$i] == '='){
				$now = 2;
				continue;
			}
			if($now == 1){
				$last_name .= $s[$i];
			}
			else {
				$last_val .= $s[$i];
			}
		}
	}
	if($now != -1){
		$arr += [$last_name => $last_val];
	}
	return $arr;
}

function mf($s){
	$res = "";
	$j = 0;
	$s .= " ";
	while ($s[$j] != " ") {
		$res .= $s[$j++];
	}
	return $res;
}

if(isset($data['authbutton'])){
	$b = false;
	$errors = array();
	$user = R::findOne('users', 'login = ?', array(
		$data['login']
	));
	if($user){
		if(password_verify($data['password'], $user->password1)){
			$b = true;
			$user = $user->export();
			$_SESSION['login'] = $user['login'];
			$_SESSION['id'] = $user['id'];
			$_SESSION['access'] = $user['access'];
			header('Location: next');
		}
		else {
			$errors[] = 'Неверно введен пароль';
		}
	}
	else {
		$errors[] = 'Пользователь с таким логином не найден';
	}
}

function mexit(){
	unset($_SESSION['login']);
	unset($_SESSION['id']);
	unset($_SESSION['access']);
	//session_destroy();
	header('Location: next');
}

function mfrename($was, $need){
	$kol = 0;
	for ($i = strlen($was)-1; $i>=0; $i--){
		if($was[$i] != '.')$kol++;
		else break;
	}
	$kol++;
	$ans = $need . substr($was, strlen($was)-$kol, $kol);
	return $ans;
}

function add_news_() {
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	$news = R::findOne('news_offered', '`id` = ?', array($arr['news_id']));
	$data = $_POST;
	if(isset($data['approve'])){
		$posted_new = R::xdispense('news_posted');
		$posted_new->title = $news->title;
		$posted_new->text = $news->text;
		$posted_new->author = $news->author;
		$posted_new->idauthor = $news->idauthor;
		$posted_new->date = date("Y-m-d H:i:s", time());
		$id_post = R::store($posted_new);
		R::trash($news);
		header('Location: news_page?news_id=' . $id_post);
	}
}

function not_add_news_() {
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	$news = R::findOne('news_offered', '`id` = ?', array($arr['news_id']));
	$data = $_POST;
	if(isset($data['not_approve'])){
		$not_posted_new = R::xdispense('news_rejected');
		$not_posted_new->title = $news->title;
		$not_posted_new->text = $news->text;
		$not_posted_new->author = $news->author;
		$not_posted_new->idauthor = $news->idauthor;
		$id_post = R::store($not_posted_new);
		R::trash($news);
		header('Location: check_news');
	}
}

function reg_on_cont_() {
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);

	//print_r($arr);
	$b = false;
	$data = $_POST;
	if(isset($data['reg_on'])){
		$errors = array();

		if(!$data['agree_rul']){
			$errors[] = 'Надо согласиться с правилами соревнования';
		}

		if(empty($errors)){
			
			$part = R::xdispense('persons_take_part');
			$part->idperson = $_SESSION['id'];
			$part->idcontest = $arr['live_contest_id'];
			$part->name_person = $_SESSION['login'];
			R::store($part);

			$tasks = R::findAll('live_contest_tasks', '`idcontest` = ?', array($arr['live_contest_id']));
			
			foreach ($tasks as $task) {
				$nnew = R::xdispense('contest_res');
				$nnew->idcontest = $arr['live_contest_id'];
				$nnew->idperson = $_SESSION['id'];
				$nnew->idtask = $task['idtask'];
				$nnew->points = 0;
				$nnew->task_name = $task['task_name'];
				R::store($nnew);
			}
			$all = R::xdispense('contest_res_all');
			$all->idcontest = $arr['live_contest_id'];
			$all->idperson = $_SESSION['id'];
			$all->login = $_SESSION['login'];
			$all->points = 0;
			$cont_temp = R::findOne('live_contests', '`id` = ?', array($arr['live_contest_id']));
			$all->date = $cont_temp['date'] + $cont_temp['duration']*60;
			$all->date = date("Y-m-d H:i:s", strtotime($cont_temp['date']) + $cont_temp['duration']*60);
			$all->contest_name = $cont_temp['name'];
			R::store($all);

			$b = true;
			header('Location: next');
		}
	}
}

function check_start() {
	$url = $_SERVER['REQUEST_URI'];
	$arr = mparse($url);
	$nowcont = R::findOne('live_contests', '`id` = ?', array($arr['live_contest_id']));
	if(strtotime($nowcont['date']) > time()){
		header('Location: next');
	}
}