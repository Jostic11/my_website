<?php
require "includes/config.php";
require "rb/rb.php";
require "includes/db.php";

$data = $_POST;
require 'includes/function.php';

$route = $_GET['route'];
if($route == "logout"){
	mexit();
}

if($route == "news_page_check"){
	add_news_();
	not_add_news_();
}

if($route == "reg_on_cont"){
	reg_on_cont_();
}

if($route == 'monitor' || $route == 'try' || $route == 'contest_tasks'){
	check_start();
}

require 'templates/head.php';
require 'templates/header.php';
require 'templates/aside.php';

//unset($_SESSION['login']);

//print_r($route);

//-------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------

if(!$_SESSION['access']){
	switch ($route) {
	case 'about':
		require 'pages/about.php';
		break;
	case 'auth':
		require 'pages/auth.php';
		break;
	case 'help':
		require 'pages/help.php';
		break;
	case 'lastevent':
		require 'pages/lastevent.php';
		break;
	case 'monitor':
		require 'pages/monitor.php';
		break;
	case 'news':
		require 'pages/news.php';
		break;
	case 'reg':
		require 'pages/reg.php';
		break;
	case 'next':
		require 'pages/next.php';
		break;
	case 'rules':
		require 'pages/rules.php';
		break;
	case 'contest':
		require 'pages/contest.php';
		break;
	case 'contest_tasks':
		require 'pages/contest_tasks.php';
		break;
	case 'task':
		require 'pages/task.php';
		break;
	case 'try':
		require 'pages/try.php';
		break;
	case 'results':
		require 'pages/results.php';
		break;
	case 'after_contest_tasks':
		require 'pages/after_contest_tasks.php';
		break;
	case 'task_conditiononly':
		require 'pages/task_conditiononly.php';
		break;
	case 'news_page':
		require 'pages/news_page.php';
		break;
	case 'try_past':
		require 'pages/try_past.php';
		break;

	default:
		require 'pages/next.php';
		break;
	}
}

//-------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------

if($_SESSION['access'] == 1){
	switch ($route) {
	case 'about':
		require 'pages/about.php';
		break;
	case 'auth':
		require 'pages/auth.php';
		break;
	case 'help':
		require 'pages/help.php';
		break;
	case 'lastevent':
		require 'pages/lastevent.php';
		break;
	case 'monitor':
		require 'pages/monitor.php';
		break;
	case 'news':
		require 'pages/news.php';
		break;
	case 'reg':
		require 'pages/reg.php';
		break;
	case 'next':
		require 'pages/next.php';
		break;
	case 'rules':
		require 'pages/rules.php';
		break;
	case 'contest':
		require 'pages/contest.php';
		break;
	case 'profile':
		require 'pages/profile.php';
		break;
	case 'contest_tasks':
		require 'pages/contest_tasks.php';
		break;
	case 'task':
		require 'pages/task.php';
		break;
	case 'try':
		require 'pages/try.php';
		break;
	case 'my_results':
		require 'pages/my_results.php';
		break;
	case 'results':
		require 'pages/results.php';
		break;
	case 'after_contest_tasks':
		require 'pages/after_contest_tasks.php';
		break;
	case 'task_conditiononly':
		require 'pages/task_conditiononly.php';
		break;
	case 'news_page':
		require 'pages/news_page.php';
		break;
	case 'try_past':
		require 'pages/try_past.php';
		break;
	case 'reg_on_cont':
		require 'pages/reg_on_cont.php';
		break;

	default:
		require 'pages/next.php';
		break;
	}
}

//-------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------

if($_SESSION['access'] == 2){
	switch ($route) {
	case 'reg_on_cont':
		require 'pages/reg_on_cont.php';
		break;
	case 'about':
		require 'pages/about.php';
		break;
	case 'auth':
		require 'pages/auth.php';
		break;
	case 'help':
		require 'pages/help.php';
		break;
	case 'lastevent':
		require 'pages/lastevent.php';
		break;
	case 'monitor':
		require 'pages/monitor.php';
		break;
	case 'news':
		require 'pages/news.php';
		break;
	case 'reg':
		require 'pages/reg.php';
		break;
	case 'next':
		require 'pages/next.php';
		break;
	case 'rules':
		require 'pages/rules.php';
		break;
	case 'contest':
		require 'pages/contest.php';
		break;
	case 'profile':
		require 'pages/profile.php';
		break;
	case 'contest_tasks':
		require 'pages/contest_tasks.php';
		break;
	case 'task':
		require 'pages/task.php';
		break;
	case 'try':
		require 'pages/try.php';
		break;
	case 'my_results':
		require 'pages/my_results.php';
		break;
	case 'results':
		require 'pages/results.php';
		break;
	case 'after_contest_tasks':
		require 'pages/after_contest_tasks.php';
		break;
	case 'task_conditiononly':
		require 'pages/task_conditiononly.php';
		break;
	case 'news_page':
		require 'pages/news_page.php';
		break;
	case 'try_past':
		require 'pages/try_past.php';
		break;

	//------------------------------------
	case 'create':
		require 'pages/create.php';
		break;
	case 'createcontest':
		require 'pages/createcontest.php';
		break;
	case 'createtask':
		require 'pages/createtask.php';
		break;
	case 'tasks':
		require 'pages/tasks.php';
		break;
	case 'my_contests':
		require 'pages/my_contests.php';
		break;
	case 'my_tasks':
		require 'pages/my_tasks.php';
		break;
	case 'edit_task':
		require 'pages/edit_task.php';
		break;
	case 'edit_contests':
		require 'pages/edit_contests.php';
		break;
	case 'create_news':
		require 'pages/create_news.php';
		break;
	case 'my_news':
		require 'pages/my_news.php';
		break;
	case 'news_offered':
		require 'pages/news_offered.php';
		break;
	case 'news_posted':
		require 'pages/news_posted.php';
		break;
	case 'edit_news':
		require 'pages/edit_news.php';
		break;
	case 'check_ans':
		require 'pages/check_ans.php';
		break;
	case 'grading':
		require 'pages/grading.php';
		break;
	case 'check_news':
		require 'pages/check_news.php';
		break;
	case 'news_rejected':
		require 'pages/news_rejected.php';
		break;
	case 'edit_news_rejected':
		require 'pages/edit_news_rejected.php';
		break;
	//--------------------------------------------------------

	default:
		require 'pages/next.php';
		break;
	}
}

//-------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------

if($_SESSION['access'] == 3){
	switch ($route) {
	
	case 'reg_on_cont':
		require 'pages/reg_on_cont.php';
		break;
	case 'about':
		require 'pages/about.php';
		break;
	case 'auth':
		require 'pages/auth.php';
		break;
	case 'help':
		require 'pages/help.php';
		break;
	case 'lastevent':
		require 'pages/lastevent.php';
		break;
	case 'monitor':
		require 'pages/monitor.php';
		break;
	case 'news':
		require 'pages/news.php';
		break;
	case 'reg':
		require 'pages/reg.php';
		break;
	case 'next':
		require 'pages/next.php';
		break;
	case 'rules':
		require 'pages/rules.php';
		break;
	case 'contest':
		require 'pages/contest.php';
		break;
	case 'profile':
		require 'pages/profile.php';
		break;
	case 'contest_tasks':
		require 'pages/contest_tasks.php';
		break;
	case 'task':
		require 'pages/task.php';
		break;
	case 'try':
		require 'pages/try.php';
		break;
	case 'my_results':
		require 'pages/my_results.php';
		break;
	case 'results':
		require 'pages/results.php';
		break;
	case 'after_contest_tasks':
		require 'pages/after_contest_tasks.php';
		break;
	case 'task_conditiononly':
		require 'pages/task_conditiononly.php';
		break;
	case 'news_page':
		require 'pages/news_page.php';
		break;
	case 'try_past':
		require 'pages/try_past.php';
		break;

	//------------------------------------
	case 'create':
		require 'pages/create.php';
		break;
	case 'createcontest':
		require 'pages/createcontest.php';
		break;
	case 'createtask':
		require 'pages/createtask.php';
		break;
	case 'tasks':
		require 'pages/tasks.php';
		break;
	case 'my_contests':
		require 'pages/my_contests.php';
		break;
	case 'my_tasks':
		require 'pages/my_tasks.php';
		break;
	case 'edit_task':
		require 'pages/edit_task.php';
		break;
	case 'edit_contests':
		require 'pages/edit_contests.php';
		break;
	case 'create_news':
		require 'pages/create_news.php';
		break;
	case 'my_news':
		require 'pages/my_news.php';
		break;
	case 'news_offered':
		require 'pages/news_offered.php';
		break;
	case 'news_posted':
		require 'pages/news_posted.php';
		break;
	case 'edit_news':
		require 'pages/edit_news.php';
		break;
	case 'check_ans':
		require 'pages/check_ans.php';
		break;
	case 'grading':
		require 'pages/grading.php';
		break;
	case 'check_news':
		require 'pages/check_news.php';
		break;
	case 'news_rejected':
		require 'pages/news_rejected.php';
		break;
	case 'edit_news_rejected':
		require 'pages/edit_news_rejected.php';
		break;
	//--------------------------------------------------------

	case 'contests':
		require 'pages/contests.php';
		break;

	case 'edit_help':
		require 'pages/edit_help.php';
		break;
	case 'edit_about':
		require 'pages/edit_about.php';
		break;
	case 'edit_rules':
		require 'pages/edit_rules.php';
		break;
	case 'check_news':
		require 'pages/check_news.php';
		break;
	case 'news_page_check':
		require 'pages/news_page_check.php';
		break;

	default:
		require 'pages/next.php';
		break;
}
}

require 'templates/footer.php';
?>