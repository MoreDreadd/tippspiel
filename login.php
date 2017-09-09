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
				Session::flash('login', '<div class="alert alert-danger" role="alert">Sie konnten nicht angemeldet werden!<br />&Uuml;berpr&uuml;fen Sie E-Mail und Passwort und stellen Sie sicher, dass Sie Ihre E-Mail bereits best&auml;tigt haben!</div>');
			}
			
		} else {
			foreach($validation->errors() as $error) {
				echo $error, "<br />";
			}
		}
		
	}
}

?>

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Tippspiel</title>
		<!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">-->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
	</head>
	<body>
		<div class="container-fluid"> <!--Hier steht alles drin-->
		<div class="page-header"><h1>Tippspiel <?php echo Session::get('meisterschafts_title'); ?></h1></div> <!--Hier ist Platz f&uuml;r ein Logo oder aehnliches-->
		<div class="jumbotron"> <!--Der Inhalt-->

			<form action="" method="POST" class="form-horizontal">
				<fieldset>
					<legend>Anmeldung:</legend>
					<?php
						if(Session::exists('login')) {
							echo Session::flash('login');
						}
					?>
					<div class="form-group">
						<label for="email" class="control-label col-sm-1">E-Mail:</label>
						<div class="col-sm-5">
							<input class="form-control" type="email" name="email" id="email" required="required" placeholder="E-Mail" />
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="control-label col-sm-1">Passwort:</label>
						<div class="col-sm-5">
							<input class="form-control" type="password" name="password" id="password" required="required" placeholder="Passwort" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-5">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" id="remember" /> Angemeldet bleiben
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-5">
							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
							<input type="submit" value="Anmelden" class="btn btn-primary" />
							<a href="index.php" class="btn btn-default" role="button">zur&uuml;ck</a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		</div>

    	<script src="js/bootstrap.js"></script>
	</body>
</html>