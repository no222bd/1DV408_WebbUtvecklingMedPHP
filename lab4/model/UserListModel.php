<?php

namespace model;

require_once('/model/UserModel.php');

// DAL class - List of user objects
class UserListModel {

	private $userList = array();
	private $dbUsername = 'njo';
	private $dbPassword = 'njo';
	private $connection;

	public function __construct() {
		$this->connectToDB();
		$this->fillUserList();
	}	

	private function connectToDB() {
		$this->connection = new \PDO('mysql:host=localhost;dbname=credentials', $this->dbUsername, $this->dbPassword);
	}

	private function fillUserList() {
		$x = $this->connection->query('SELECT Username, Password FROM User');
		
		while($row = $x->fetch()) {
			$this->userList[] = new \model\UserModel($row['Username'], $row['Password'], false);
		}
	}

	public function saveUser(\model\UserModel $user) {
		
		$sql = 'INSERT INTO User (Username, Password)
				VALUES (:username, :password)';

		$stmt = $this->connection->prepare($sql);

		$stmt->execute(array(
			':username' => $user->getUsername(),
			':password' => $user->getPassword())
		);
	}

	public function getUserList() {
		return $this->userList;
	}

}