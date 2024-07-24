<?php
	//main path
	define('DIR',					__DIR__."/../../");
	define('ROOT',					__DIR__."/../../../");

	//Конфигурация URL
	define('BASE_URL',				$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/');

	define('ADMIN_URL',				BASE_URL . 'admin/');

	define('LOGIN_URL',				BASE_URL . 'auth/login');
	define('LOGOUT_URL',			BASE_URL . 'auth/logout');

	// Доп URL
	define('JS_URL',				BASE_URL . 'assets/js/');
	define('AJAX_URL',				BASE_URL . 'ajax/');
	define('API_URL',				BASE_URL . 'api/');
?>