<?php

namespace model;

class UserModel {
	
	private $username;
	private $password;

	// Exception messages
	private static $tooShortUsernameMessage = 'Användarnamnet har för få tecken. Minst 3 tecken';
	private static $tooShortPasswordMessage = 'Lösenorden har för få tecken. Minst 6 tecken';
	private static $invalidCharactersMessage = 'Användarnamnet innehåller ogiltiga tecken';

	// Create user after validation
	public function __construct($username, $password, $validate = true ) {

		if($validate) {

			if(mb_strlen($username) < 3 && mb_strlen($password) < 6)
				throw new \TooShortCredentialsException(self::$tooShortUsernameMessage, self::$tooShortPasswordMessage);

			if(mb_strlen($username) < 3)
				throw new \Exception(self::$tooShortUsernameMessage);

			if(mb_strlen($username) !== mb_strlen(strip_tags($username)))
				throw new \Exception(self::$invalidCharactersMessage);

			if(mb_strlen($password) < 6)
				throw new \Exception(self::$tooShortPasswordMessage);
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