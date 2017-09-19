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
				)
			));
			
			if($validation->passed()){
				$email = Input::get('email');
				$db = DB::getInstance();
				$user = new User();
				if(!$user->find($email)) {
					Session::flash('home', '<div class="alert alert-danger" role="alert">Es existiert kein Konto mit dieser E-Mail Adresse!</div>');
					Redirect::to('index.php');
				} else {
					$name = $user->data()->name;
					$userID = $user->data()->id;
				}


				$salt = Hash::salt(32);
				$subject = 'Tippspiel: Passwort zuruecksetzen';
				$email_hash = Hash::unique();

				$email_body = "
					Hallo {$name}, \n
					\n
					Sie erhalten diese Mail, weil Sie Ihr Passwort vergessen haben.\n
					Sollten Sie nicht versucht haben, Ihr Passwort zurückzusetzen, ignorieren Sie diese Mail einfach.\n
					Ansonsten klicken Sie bitte auf den folgenden Link, um Ihr Passwort zurückzusetzen: \n
					\n
					tippspiel25.bplaced.net/resetPassword.php?hash={$email_hash} \n
					\n
					Viel Glück beim Tippen! \n
					\n
					Der Administrator
				";


				try {

					if(!mail($email, $subject, $email_body)){
						Session::flash('home', '<div class="alert alert-danger" role="alert">Es gab ein Problem! Bitte versuchen Sie es erneut oder kontaktieren Sie den Administrator</div>');
						Redirect::to('index.php');
					}

					$db->update('users', $userID, array(
						'email_hash' => $email_hash
					));
					
					Session::flash('home', '<div class="alert alert-success" role="alert">Ihr Passwort wurde erfolgreich zur&uuml;ckgesetzt. Bitte &uuml;berpr&uuml;fen Sie Ihren Posteingang, um den Vorgang abzuschlie&szlig;en.</div>');
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

<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Tippspiel</title>
		<link href="css/bootstrap.css" rel="stylesheet">
    	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	</head>
	<body style="padding: 40px">
		<div class="container-fluid"> <!--Hier steht alles drin-->
		<div class="page-header"><h1>Tippspiel <?php echo Session::get('meisterschafts_title'); ?></h1></div>
		<div class="jumbotron"> <!--Der Inhalt-->

			<form action="" method="POST" class="form-horizontal">
				<fieldset>
					<legend>Passwort zur&uuml;cksetzen:</legend>
						<?php
						if(isset($errors)) {
							echo "<div class='alert alert-danger' role='alert'>";
							foreach($errors as $error) {
									echo $error, '<br />';
							}
							echo "</div>";
						}
						?>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Ihre E-Mail:</label>
						<div class="col-sm-5">
							<input class="form-control" placeholder="E-Mail" type="email" name="email" id="email" required="required" value="<?php echo escape(Input::get('email')); ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-5">
							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
							<input type="submit" value="Passwort zur&uuml;cksetzen" class="btn btn-primary" />
							<a href="login.php" class="btn btn-default" role="button">zur&uuml;ck</a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		</div>

    	<script src="js/bootstrap.js"></script>
	</body>
</html>