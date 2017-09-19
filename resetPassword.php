<?php

require_once 'core/init.php';

	if(!Input::get('hash')) {
		Session::flash('home', '<div class="alert alert-danger" role="alert">Der Link, den Sie eingegeben haben, ist ung&uuml;ltig.</div>');
		Redirect::to('index.php');
	}

	if(Input::exists()) {

		if(Token::check(Input::get('token'))) {
			
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'password' => array(
					'name' => 'Passwort',
					'required' => true,
					'min' => 6
				),
				'password_again' => array(
					'name' => 'erneutem Passwort',
					'required' => true,
					'matches' => 'password'
				)
			));
			
			if($validation->passed()){
				$user = new User();
				if($user->changePassword(Input::get('password'), Input::get('hash'))) {
					Session::flash('home', '<div class="alert alert-success" role="alert">Ihr Passwort wurde erfolgreich geändert.</div>');
					Redirect::to('index.php');
				} else {
					Session::flash('passwordReset', '<div class="alert alert-danger" role="alert">Ihr Passwort konnte nicht zur&uuml;ckgesetzt werden.</div>');
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
	<title>Passwort zur&uuml;cksetzen</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="padding: 40px">
	<div class="container-fluid">
	<div class="page-header"><h1>Tippspiel <?php echo Session::get('meisterschafts_title'); ?></h1></div>
	<div class="jumbotron">
	<?php
		if(Session::exists('passwordReset')) {
			echo Session::flash('passwordReset');
		}
		if(isset($errors)) {
			echo "<div class='alert alert-danger' role='alert'>";
			foreach($errors as $error) {
					echo $error, '<br />';
			}
			echo "</div>";
		}
	?>
		<form method="POST" action="">
			<fieldset>
				<legend>Neues Passwort eingeben:</legend>
				<div class="form-group">
					<input type="password" class="form-control" name="password" id="password" placeholder="Passwort" required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="password_again" id="password_again" placeholder="Passwort wiederholen" required>
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
				<input class="btn btn-primary" type="submit" name="submit" value="Passwort &auml;ndern">
			</fieldset>
		</form>
	</div>
	</div>
</body>
</html>