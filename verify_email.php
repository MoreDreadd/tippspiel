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
				Session::flash('home', '<div class="alert alert-success" role="alert">Ihre E-Mail Adresse wurde erfolgreich verifiziert.<br />Sie k&ouml;nnen sich nun anmelden.</div>');
			} else {
				Session::flash('home', '<div class="alert alert-danger" role="alert">Ihre E-Mail Adresse konnte nicht verifiziert werden.</div>');
			}

		}

	} else {
		Session::flash('home', '<div class="alert alert-danger" role="alert">Ihre E-Mail Adresse konnte nicht verifiziert werden.</div>');
		echo "No input!";
	}

	Redirect::to('index.php');


?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<!--<link rel="shortcut icon" type="image/x-icon" href="icon.ico">-->
		<title>Tippspiel</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="container-fluid"> <!--Hier steht alles drin-->
		<div id="kopf"><h1>Tippspiel EM 2016</h1></div> <!--Hier ist Platz f&uuml;r ein Logo oder aehnliches-->
		<div id="inhalt"> <!--Der Inhalt-->
			Ihre E-Mail wird verifiziert....
		</div>
	</body>
</html>
<?php
	}
?>