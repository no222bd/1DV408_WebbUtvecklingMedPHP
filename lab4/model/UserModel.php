<?php

namespace model;

class UserModel {
	
	private $username;
	private $password;

	// Create user after validation
	public function __construct($username, $password, $validate = true ) {

		if($validate) {

			if(mb_strlen($username) < 3 && mb_strlen($password) < 6)
				throw new \TooShortCredentialsException();

			if(mb_strlen($username) < 3)
				throw new \Exception('Användarnamnet har för få tecken. Minst 3 tecken');

			if(mb_strlen($username) !== mb_strlen(strip_tags($username)))
				throw new \Exception('Användarnamnet innehåller ogiltiga tecken');

			if(mb_strlen($password) < 6)
				throw new \Exception('Lösenorden har för få tecken. Minst 6 tecken');
		}
		
		$this->username = $username;
		$this->password = $password;
	}

	// Check if username is already in use
	public function equals(\model\UserModel $otherUser) {
		if($this->username !== $otherUser->username)
			return false;

		if($this->password !== $otherUser->password)
			return false;

		return true;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}
}