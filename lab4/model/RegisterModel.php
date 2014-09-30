<?php

namespace model;

class RegisterModel {

	public function createUser($username, $password, $repeatedPassword) {

		$userList = new \model\UserListModel();
	
		// Check that passwords match and then create user
		if($password !== $repeatedPassword)
			throw new \Exception('Lösenorden matchar inte');

		// Get list of existing users
		$list = $userList->getUserList();

		// Check if username already exists			
		foreach ($list as $existingUser) {
			if($existingUser->getUsername() == $username)
				throw new \Exception('Användarnamnet är redan upptaget');
		}

		// Create new user
		$user = new \model\UserModel($username, $password);
		
		// Save the new user to the database
		$userList->saveUser($user);

		// Returns that creation of user was successful
		return true;
	}
}