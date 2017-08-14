<?php

require_once 'core/init.php';

	if(Input::exists()) {
		if(Token::check(Input::get('token'))) {
			
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'email' => array(
					'name' => 'E-Mail',
					'required' => true,
					'min' => 2,
					'max' => 50,
					'unique' => 'users'
				),
				'password' => array(
					'name' => 'Passwort',
					'required' => true,
					'min' => 6
				),
				'password_again' => array(
					'name' => 'erneutem Passwort',
					'required' => true,
					'matches' => 'password'
				),
				'name' => array(
					'name' => 'Ihr Name',
					'required' => true,
					'min' => 2,
					'max' => 50,
					'unique' => 'users'
				)
			));
			
			if($validation->passed()){
				$user = new User();

				$salt = Hash::salt(32);

				$email = Input::get('email');
				$subject = 'Account Aktivierung Tippspiel';
				$email_hash = Hash::unique();
				$name = Input::get('name');

				$email_body = "
					Hallo {$name}, \n
					\n
					vielen Dank, dass Sie Sich beim Tippspiel registriert haben.\n
					Bitte klicken Sie auf den folgenden Link, um Ihre E-Mail Adresse zu bestätigen und Ihr Konto zu aktivieren: \n
					\n
					tippspiel25.bplaced.net/verify_email.php?hash={$email_hash} \n
					\n
					Viel Glück beim Tippen! \n
					\n
					Der Administrator
				";


				try {

					if(!mail($email, $subject, $email_body)){
						Redirect::to('index.php');
					}

					$user->create(array(
						'email' => $email,
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt,
						'name' => $name,
						'joined' => date('Y-m-d H:i:s'),
						'activated' => 0,
						'email_hash' => $email_hash,
						'group' => 1
					));
					
					Session::flash('home', 'Ihr Konto wurde erfolgreich erstellt!<br />Bitte &uuml;berpr&uuml;fen Sie Ihren Posteingang und best&auml;tigen Sie Ihre E-Mail Adresse, um Ihr Konto zu aktivieren.');
					Redirect::to('index.php');
					
				} catch(Exception $e) {
					die($e->getMessage());
				}
			} else {
				$errors = $validation->errors();
				/**foreach($validation->errors() as $error) {
					echo $error, '<br />';
				}**/
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
		<link href="css/bootstrap.css" rel="stylesheet">
    	<link href="css/bootstrap-responsive.css" rel="stylesheet">
		<!--<link rel="stylesheet" type="text/css" href="style.css">-->
	</head>
	<body>
		<div class="container-fluid"> <!--Hier steht alles drin-->
		<div class="page-header"><h1>Tippspiel <?php echo Session::get('meisterschafts_title'); ?></h1></div> <!--Hier ist Platz f&uuml;r ein Logo oder aehnliches-->
		<div class="hero-unit"> <!--Der Inhalt-->

			<form action="" method="POST">
				<fieldset>
					<legend>Registrieren:</legend>
					<p class="text-error">
						<?php
						if(isset($errors)) {
							foreach($errors as $error) {
									echo $error, '<br />';
							}
							echo "<br />";
						}
						?>
					</p>
					<label for="email">E-Mail:</label>
					<input type="text" name="email" id="email" required="required" value="<?php echo escape(Input::get('email')); ?>" />
					<br />
					<label for="password">Passwort:</label>
					<input type="password" name="password" id="password" required="required" />
					<br />
					<label for="password_again">Passwort wiederholen:</label>
					<input type="password" name="password_again" id="password_again" required="required" />
					<br />
					<label for="name">Vor- und Nachname</label>
					<input type="text" name="name" id="name" required="required" value="<?php echo escape(Input::get('name')); ?>" />
					<br />
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
					<input type="submit" value="Registrieren" class="btn btn-primary" />
					<a href="index.php" class="btn">zur&uuml;ck</a>
				</fieldset>
			</form>
		</div>
		</div>

    	<script src="js/bootstrap.js"></script>
	</body>
</html>