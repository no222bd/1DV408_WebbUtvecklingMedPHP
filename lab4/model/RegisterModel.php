<?php

namespace model;

class RegisterModel {

	/*private $userList;

	public function __construct() {
		$this->userList = new \model\UserListModel();
	}*/

	public function createUser($username, $password, $repeatedPassword) {

			// CHANGE from constructor
			$userList = new \model\UserListModel();

		
			//  Check that passwords match and then create user
			if($password !== $repeatedPassword) {
				throw new \Exception('Lösenorden matchar inte');
			} else {
				$user = new \model\UserModel($username, $password);
			}
				
			// Place the check if user already exists in UserList or here?

			// Get list of existing users
			$list = $userList->getUserList();

			// Check if username already exists			
			foreach ($list as $existingUser) {
				if($user->equals($existingUser))
					throw new \Exception('Användarnamnet är redan upptaget');
			}
			
			// Save the new user to the database
			$userList->saveUser($user);

		
	}
}