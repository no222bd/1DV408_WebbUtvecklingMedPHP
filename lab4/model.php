<?php
    
namespace model;

// no222bd - Added requir_once to be able to create and compare user to existing users ====
require_once('/model/UserListModel.php');
require_once('/model/UserModel.php');

class Model{

	// no222bd - Saved name location in $_SESSION =========================================
	private $currentUser = 'currentUser';

	// no222bd - Get username from $_SESSION ==============================================
	public function getCurrentUsername() {
		return $_SESSION[$this->currentUser];
	}

	/*public function checkCredentials($username, $password) {
		$userListObject = new \model\UserListModel();
		$userList = $userListObject->getUserList();

		foreach ($userList as $user) {
			if($username == $user->getUsername() && $password == $user->getPassword()) {
				$_SESSION[$this->currentUser] = $username;
				return true;
			}
		}

		return false;
	}*/

	// no222bd - Check if user enterd valid credentials ==================================
	public function checkCredentials($username, $password) {
		$userList = (new \model\UserListModel())->getUserList();
		//var_dump($userList);
		//die();
		$user = new \model\UserModel($username, $password, false);

		foreach($userList as $existingUser) {
			if($user->equals($existingUser)) {
				$_SESSION[$this->currentUser] = $username;
				return true;
			}
		}

		return false;
	}
	
	// no222bd - Deleted code =============================================================
	/*/**
	* @var string
	*/
	//private $admin = "Admin";
	
	/**
	* @var string
	*/
	//private $password = "Password";

	/**
	 * @return string
	 * retunerar det korrekta användarnamnet
	 */
	//public function getAdmin(){
		
	//	return $this->admin;
	//}
	
	/**
	 * @return string
	 * retunerar det korrekta lösenordet.
	 */
	//public function getPassword(){
		
	//	return $this->password;
	//}

	/**
	* @var string
	*/
	private $loginSession = "loginSession";
	
	/**
	* @var string
	*/
	private $sessionController = "Session controller";
		
	/**
	* @var string
	*/
	private $ip = "ip";
		
	/**
	* @var string
	*/
	private $browser = "browser";
		
	/**
	* @var string
	*/
	private $agent = "HTTP_USER_AGENT";
		
	/**
	* @var string
	*/
	private $remote = "REMOTE_ADDR";
	
	/**
	* @var string
	*/
	private $cookiePass = "segopunsefgipuwegi";
	
	/**
	 * @var string
	 */
	private $salt = "salt";
	
	/**
	 * startar sessionen för inloggning.
	 */
	public function startSession(){
		
		$_SESSION[$this->loginSession] = true;
	}
	
	/**
	 * @return bool
	 * retunerar true om login sessionen är satt.
	 */
	public function isUserLoggedIn(){
		
		if(isset($_SESSION[$this->loginSession])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return string
	 * retunerar kakans lösen.
	 */
	public function getCookiePass(){
		
		return $this->cookiePass;
	}
	
	/**
	 * @return string
	 * retunerar krypteringskoden.
	 */
	public function getSalt(){
		
		return $this->salt;
	}
	
	/**
	 * @return bool
	 * Kontrollerar sessionen mot användarens ip,
	 * webbläsare osv. Stämmer inte sessionen tas den bort.
	 */
	public function checkSession(){
		
		if(isset($_SESSION[$this->sessionController]) == false){
				$_SESSION[$this->sessionController] = array();
				$_SESSION[$this->sessionController][$this->browser] = $_SERVER[$this->agent];
				$_SESSION[$this->sessionController][$this->ip] = $_SERVER[$this->remote];
			}

			if($_SESSION[$this->sessionController][$this->browser] != $_SERVER[$this->agent]){
				
				$this->destroySession();

				return true;
			}
			return false;
	}
	
	/**
	 * Tar bort sessionen
	 */
	public function destroySession(){
			
		unset($_SESSION[$this->loginSession]);
	}
}
?>