<?php
class User {
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;
	
	public function __construct($user = null) {
		$this->_db = DB::getInstance();
		
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		
		if(!$user) {
			if(Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				
				if($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					//logout
				}
			}
		} else {
			$this->find($user);
		}
	}
	
	public function create($fields = array()) {
		if(!$this->_db->insert('users', $fields)) {
			throw new Exception('Das Konto konnte nicht erstellt werden.');
		}

	}
	
	public function find($user = null) {
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'email';
			$data = $this->_db->get('users', array($field, '=', $user));
			
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function login($email = null, $password = null, $remember = false) {
		
		if(!$email && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
			Session::put('username', $this->data()->name);
		} else {
			$user = $this->find($email);

			if($user) {
				if($this->data()->activated == 1 && $this->data()->email_hash == '') {
					if($this->data()->password === Hash::make($password, $this->data()->salt)) {
						Session::put($this->_sessionName, $this->data()->id);
						Session::put('username', $this->data()->name);

						if($remember) {

							$hash = Hash::unique();
							$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

							if(!$hashCheck->count()) {
								$this->_db->insert('users_session', array(
									'user_id' => $this->data()->id,
									'hash' => $hash
								));
							} else {
								$hash = $hashCheck->first()->hash;
							}

							Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

						}

						return true;
					}
				}
			}

		}

		return false;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}
	
	public function logout() {

		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	
	public function data() {
		return $this->_data;
	}
	
	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

	public function hasPermission($group) {
		if($group <= $this->data()->group) {
			return true;
		}
		return false;
	}

	public function verifyEmail($hash) {

		$data = $this->_db->get('users', array('email_hash', '=', $hash))->first();
		$userID = $data->id;

		if($userID) {

			$this->_db->update('users', $userID, array(
				'activated' => 1,
				'email_hash' => ''
			));

			return true;

		}

		return false;

	}

	public function changePassword($newPW, $hash) {
		$salt = Hash::salt(32);
		$data = $this->_db->get('users', array('email_hash', '=', $hash));
		if($this->_db->count() == 0) {
			return false;
		} else {
			$userID = $data->first()->id;
		}

		if($userID) {

			$this->_db->update('users', $userID, array(
				'email_hash' => '',
				'password' => Hash::make($newPW, $salt),
				'salt' => $salt
			));

			return true;

		}

		return false;
	}
}