<?php
    
namespace model;

class Model{
	
	/**
	* @var string
	*/
	private $admin = "Admin";
	
	/**
	* @var string
	*/
	private $password = "Password";
	
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
	 * @return string
	 * retunerar det korrekta användarnamnet
	 */
	public function getAdmin(){
		
		return $this->admin;
	}
	
	/**
	 * @return string
	 * retunerar det korrekta lösenordet.
	 */
	public function getPassword(){
		
		return $this->password;
	}
	
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