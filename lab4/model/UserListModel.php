<?php

namespace model;

class UserListModel {

	// Array containing User objects
	private $userList = array();
	
	// DB settings
	private static $dbUsername = 'njo';
	private static $dbPassword = 'njo';
	private static $dbConnectionString = 'mysql:host=localhost;dbname=credentials';

	// DB table and it's columns
	private static $tableName = 'User';
	private static $usernameColumn = 'Username';
	private static $passwordColumn = 'Password';

	public function __construct() {
		$this->fillUserList();
	}

	// Connect to DB
	private function connectToDB() {
		try {
			return new \PDO(self::$dbConnectionString, self::$dbUsername, self::$dbPassword);
		} catch(\PDOException $e) {
			throw new \PDOException('Ett fel inträffade vid anslutning till databasen');
		}
	}

	// Fill the private member userList with User objects from DB
	private function fillUserList() {
		
		$connection = $this->connectToDB();

		try {
			$stmt = $connection->query('SELECT ' . self::$usernameColumn . ', ' . self::$passwordColumn . ' FROM ' . self::$tableName);
			
			while($row = $stmt->fetch()) {
				$this->userList[] = new \model\UserModel($row[self::$usernameColumn], $row[self::$passwordColumn], false);
			}
		} catch(\PDOException $e) {
			throw new \PDOException('Ett fel inträffade vid hämtamdet av giltiga användaruppgifter');
		}
	}

	// Save a User object to DB
	public function saveUser(\model\UserModel $user) {
		
		$connection = $this->connectToDB();
		
		try {
			$sql = 'INSERT INTO ' . self::$tableName . ' (' . self::$usernameColumn . ', ' . self::$passwordColumn . ')
					VALUES (:username, :password)';

			$stmt = $connection->prepare($sql);

			$stmt->execute(array(
				':username' => $user->getUsername(),
				':password' => $user->getPassword())
			);
		} catch(\PDOException $e) {
			throw new \PDOException('Ett fel inträffade vid sparandet av användaren');
		}

	}

	public function getUserList() {
		return $this->userList;
	}
}