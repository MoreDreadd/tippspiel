<?php
session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'tippspiel25',
		'password' => '****',
		'db' => 'tippspiel25'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	),
	'meisterschaft' => array(
		'meisterschafts_id' => 3
	)
);

spl_autoload_register(function($class) {
	require_once 'classes/' . $class . '.php';
});

$meisterschafts_title = DB::getInstance()->get('meisterschaft', array('ID', '=', Config::get('meisterschaft/meisterschafts_id')))->first()->Name;
Session::put('meisterschafts_title', $meisterschafts_title);

require_once 'functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}