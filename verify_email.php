<?php

require_once 'core/init.php';

$user = new User();
if($user->isLoggedIn()) {
	Redirect::to('main.php');
} else {

	if(Input::exists('get')) {

		$hash = Input::get('hash');

		if($hash) {

			if($user->verifyEmail($hash)){
				Session::flash('home', 'Ihre E-Mail Adresse wurde erfolgreich verifiziert.<br />Sie k&ouml;nnen sich nun anmelden.');
			} else {
				Session::flash('home', 'Ihre E-Mail Adresse konnte nicht verifiziert werden.');
			}

		}

	} else {
		Session::flash('home', 'Ihre E-Mail Adresse konnte nicht verifiziert werden.');
		echo "No input!";
	}

	Redirect::to('index.php');


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<!--<link rel="shortcut icon" type="image/x-icon" href="icon.ico">-->
		<title>Tippspiel</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="container"> <!--Hier steht alles drin-->
		<div id="kopf"><h1>Tippspiel EM 2016</h1></div> <!--Hier ist Platz f&uuml;r ein Logo oder aehnliches-->
		<div id="inhalt"> <!--Der Inhalt-->
			Ihre E-Mail wird verifiziert....
		</div>
	</body>
</html>
<?php
	}
?>