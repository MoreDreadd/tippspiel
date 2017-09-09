<?php

require_once 'core/init.php';

$user = new User();
if($user->isLoggedIn()) {
	Redirect::to('main.php');
} else {
?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<!--<link rel="shortcut icon" type="image/x-icon" href="icon.ico">-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Tippspiel</title>
		<!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">-->
		<!--<link rel="stylesheet" type="text/css" href="style.css">-->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid"> <!--Hier steht alles drin-->
		<div class="page-header"><h1>Tippspiel <?php echo Session::get('meisterschafts_title'); ?></h1></div> <!--Hier ist Platz f&uuml;r ein Logo oder aehnliches-->
		<div class="jumbotron"> <!--Der Inhalt-->
		<?php
			if(Session::exists('home')) {
				echo Session::flash('home');
			}
		?>
		Herzlich willkommen zum Tippspiel zur <?php echo Session::get('meisterschafts_title'); ?>.
		<br />
		<br />
		<br />
		Sie haben bereits ein Konto? Hier geht es zur <a href="login.php">Anmeldung</a>.
		<br />
		<br />
		Neu hier? Dann <a href="register.php">registrieren</a> Sie sich jetzt.
		</div>
		<footer>
			<p class="pull-right"><a href="#">nach oben</a></p>
			<p>&copy; 2017 Fabian Ferrari &middot; <a href="impressum.php">Impressum</a></p>
		</footer>
		</div>

		<script src="js/bootstrap.js"></script>
	</body>
</html>
<?php
	}
?>