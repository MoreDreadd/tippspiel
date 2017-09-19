<?php

	if(Input::exists()) {
		$title = Input::get('title');
		$text = Input::get('text');
		$id = Session::get(Config::get('session/session_name'));

		$db = DB::getInstance();

		$user = new User();
		if($user->find($id)) {
			if($user->hasPermission(2)) {
				$db->insert('news', array(
					'title' => $title,
					'text' => $text,
					'author' => $id
				));
			}
		}
	}

?>

<br />
<br />
<form method="POST" action="#">
	<fieldset>
		<legend>Neuen Eintrag verfassen:</legend>
		<div class="form-group">
			<input type="text" class="form-control" name="title" id="title" placeholder="Titel" required>
		</div>
		<div class="form-group">
			<textarea class="form-control" rows="5" placeholder="Text" id="text" name="text" required></textarea>
		</div>
		<input class="btn btn-primary" type="submit" name="submit" value="Absenden">
	</fieldset>
</form>