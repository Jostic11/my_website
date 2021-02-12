<?php
	R::setup( 'mysql:host=localhost;dbname=r91796f7_proekt', 'r91796f7_proekt', 'Malov101201Malov');
	//R::setup( 'mysql:host=127.0.0.1;dbname=proekt', 'root', '');

	if(!R::testConnection()){
		exit("Нет подключения к базе данных");
	}

	R::ext('xdispense', function($table_name){
		return R::getRedBean()->dispense($table_name);
	});

	session_start();
?>