<?php

require_once 'core/init.php';

if(Input::exists()) {
					
	if(Token::check(Input::get('token'))){
		
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'email' => array(
				'name' => 'E-Mail',
				'required' => true
			),
			'password' => array(
				'name' => 'Passwort',
				'required' => true
			)
		));
		
		if($validation->passed()) {
			$user = new User();

			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $user->login(Input::get('email'), Input::get('password'), $remember);
			
			if($login) {
				Redirect::to('main.php');
			} else {
				Session::flash('login', 'Sie konnten nicht angemeldet werden!<br />&Uuml;berpr&uuml;fen Sie E-Mail und Passwort und stellen Sie sicher, dass Sie Ihre E-Mail bereits best&auml;tigt haben!');
			}
			
		} else {
			foreach($validation->errors() as $error) {
				echo $error, "<br />";
			}
		}
		
	}
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<!--<link rel="shortcut icon" type="image/x-icon" href="icon.ico">-->
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tippspiel</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
		<!--<link rel="stylesheet" type="text/css" href="style.css">-->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid"> <!--Hier steht alles drin-->
		<div class="page-header"><h1>Tippspiel <?php echo Session::get('meisterschafts_title'); ?></h1></div> <!--Hier ist Platz f&uuml;r ein Logo oder aehnliches-->
		<div class="hero-unit"> <!--Der Inhalt-->

			<form action="" method="POST">
				<fieldset>
					<legend>Anmeldung:</legend>
					<?php
						if(Session::exists('login')) {
							echo '<p class="text-error">' . Session::flash('login') . '</p>';
						}
					?>
					<label for="email">E-Mail:</label>
					<input type="text" name="email" id="email" required="required" />
					<br />
					<label for="password">Passwort:</label>
					<input type="password" name="password" id="password" required="required" />
					<label for="remember" class="checkbox">
						<input type="checkbox" name="remember" id="remember" /> Angemeldet bleiben
					</label>
					<br />
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
					<input type="submit" value="Anmelden" class="btn btn-primary" />
					<a href="index.php" class="btn">zur&uuml;ck</a>
				</fieldset>
			</form>
		</div>
		</div>

    	<script src="js/bootstrap.js"></script>
	</body>
</html>