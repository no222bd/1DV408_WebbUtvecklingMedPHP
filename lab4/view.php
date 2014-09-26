<?php
    
namespace view;

// no222bd - Added require_Once =====================================================================
require_once('view/MasterView.php');

class View{
		
	// no222bd - Added private member referencing a MasterView ======================================
	private $masterView;

	public function __construct() {
		$this->masterView = new \view\MasterView();
	}

	/**
	 * @var int
	 */
	const COOKIE = 0;
	/**
	 * @var int
	 */
	const LOGGED_IN = 1;
	
	/**
	 * @var int
	 */
	const LOGGED_IN_AND_REMEMBER_YOU = 2;
	
	/**
	 * @var int
	 */
	const LOGGED_OUT = 3;
	
	/**
	 * @var int
	 */
	const NO_TAGS = 4;
	
	/**
	 * @var int
	 */
	const WRONG_COOKIE = 5;
	
	/**
	 * @var int
	 */
	const USERNAME_EMPTY = 6;
	
	/**
	 * @var int
	 */
	const PASSWORD_EMPTY = 7;
	
	/**
	 * @var int
	 */
	const BOTH_WRONG = 8;

	/**
	 * @var string
	 */
	private $userName = "username";
	
	/**
	 * @var string
	 */
	private $password = "password";
	
	/**
	 * @var string
	 */
	private $loginBox = "loginBox";
	
	/**
	 * @var string
	 */
	private $loginButton = "loginButton";
	
	/**
	 * @var string
	 */
	private $logout = "logout";
	
	/**
	 * @var string
	 */
	public $message;
	
	/**
	 * @var string
	 */
	private $cookieName = "cookieName";
	
	/**
	 * @var string
	 */
	private $cookiePass = "cookiePass";
	
	/**
	 * @return string
	 * retunerar det inmatade användarnamnet.
	 */
	public function getUserName(){
		
		if(isset($_POST[$this->userName])){
			
			return $_POST[$this->userName];
		}
	}
	
	/**
	 * @return string
	 * retunerar det inmatade användarnamnet
	 * utan whitespace och taggar.
	 */
	public function getStripUserName(){
		
		if(isset($_POST[$this->userName])){
			return trim(strip_tags($_POST[$this->userName]));
		}
	}
	
	/**
	 * @return string
	 * retunerar det inmatade lösenordet.
	 */
	public function getPassword(){
		
		if(isset($_POST[$this->password])){
			return $_POST[$this->password];
		}
	}
	
	/**
	 * @return string
	 * retunerar det inmatade lösenordet
	 * utan whitespace och taggar.
	 */
	public function getStripPassword(){
		
		if(isset($_POST[$this->password])){
			return trim(strip_tags($_POST[$this->password]));
		}
	}
	
	/**
	 * @return bool
	 * retunerar true om användaren försöker logga in.
	 */
	public function tryToLogin(){
		
		if(isset($_POST[$this->loginButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return bool
	 * retunerar true om användaren försöker logga ut.
	 */
	public function tryToLogOut(){
			
		if(isset($_GET[$this->logout])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return bool
	 * retunerar true om användare kryssat i
	 * "Håll mig inloggad" och loggar in.
	 */
	public function getLoginBox(){
		
		if(isset($_POST[$this->loginBox])){
			return true;
		}
		return false;
	}
	
	/**
	 * @param userName string
	 * @param password string
	 * @param salt string
	 * Skapar kakorna med namn, value och krypterar lösen.
	 * Skapar även en textfil med kakornas tid.
	 */
	public function bakeCookie($userName, $password, $salt){
		
		$time = time() + 30;
				
		file_put_contents("cookieTime.txt", $time);
				
		 setcookie($this->cookieName, $userName, $time);
		$cryptPass = md5($password, $salt);
			
		setcookie($this->cookiePass, $cryptPass, $time);
		
	}
	
	/**
	 * @return bool
	 * Kontrollerar om kakorna existerar.
	 */
	public function cookieExist(){

		if(isset($_COOKIE[$this->cookieName]) && (isset($_COOKIE[$this->cookiePass]))){
			return true;
		}
		return false;
	}
	
	/**
	 * @param userName string
	 * @param password string
	 * @param salt
	 * @return bool
	 * Kontrollerar kakornas tid med textfilen.
	 * Kontrollerar sedan om namn och lösen stämmer.
	 */
	public function checkCookie($userName, $password, $salt){
		
		$timeFile = file_get_contents("cookieTime.txt");
			
			if($timeFile > time()){
				
				if($_COOKIE[$this->cookieName] == $userName && 
					$_COOKIE[$this->cookiePass] == md5($password, $salt)){
		
					return true;
				}	
			}
			return false;
	}
	
	/**
	 * Förstör kakorna.
	 */
	public function destroyCookie(){

		setcookie($this->cookieName, "", time()-99999999);
		setcookie($this->cookiePass, "", time()-99999999);
		
	}
	
	/**
	 * @param messageType int
	 * Skickar ut meddelande beroende på vad den får in.
	 */
	public function setMessage($messageType = 0) {
			switch($messageType) {
				case self::COOKIE:
					$this->message = "<p class = 'felinloggning'>Inloggning lyckades via cookies</p>";
					break;
				case self::LOGGED_IN:
					$this->message = "<p class = 'felinloggning'>Du är inloggad</p>";
					break;
				case self::LOGGED_IN_AND_REMEMBER_YOU:
					$this->message = "<p class = 'felinloggning'>Du är inloggad och vi kommer att komma ihåg dig</p>";
					break;
				case self::LOGGED_OUT:
					$this->message = "<p class = 'felinloggning'>Du är utloggad</p>";
					break;
				case self::NO_TAGS:
					$this->message ="<p class = 'felinloggning'>Inga otillåtna tecken eller mellanslag</p>";
					break;
				case self::WRONG_COOKIE:
					$this->message = "<p class = 'felinloggning'>Felaktig kaka</p>";
					break;
				case self::USERNAME_EMPTY:
					$this->message = "<p class = 'felinloggning'>Användarnamn saknas</p>";
					break;
				case self::PASSWORD_EMPTY:
					$this->message = "<p class = 'felinloggning'>Lösenord saknas</p>";
					break;
				case self::BOTH_WRONG:
					$this->message = "<p class = 'felinloggning'>Fel användarnamn och/eller lösenord</p>";
					break;
				default:
					$this->message = (string) NULL;
					break;
			}
		}
	
	// no222bd - Added link to register =======================================================================
	/**
	 * Visar loginsidan.
	 */
	public function showLoginPage(){
		
          echo  $this->masterView->basicHeader() .
          "<h1>Laboration 4</h1><h2>Ej Inloggad</h2>
          <p><a href='?register'>Registrera</a></p>
			<form action='?login' method='post' enctype='multipart/form-data'>
				<fieldset>
					<legend>Login - Skriv in användarnamn och lösenord</legend>
					".$this->message."
					<label for='UserNameID' >Användarnamn :</label>
					<input type='text' size='20' name='".$this->userName."' id='".$this->userName."' value='".$this->getStripUserName()."' />
					<label for='PasswordID' >Lösenord  :</label>
					<input type='password' size='20' name='".$this->password."' id='".$this->password."' value='' />
					<label for='AutologinID' >Håll mig inloggad  :</label>
					<input type='checkbox' name='".$this->loginBox."' id='AutologinID' />
					<input type='submit' name='".$this->loginButton."'  value='Logga in' />
				</fieldset>
			</form>"
			 . $this->masterView->basicFooter(); 
	}
	
	// no222bd - Added argument to method for dynamic username ===============================================
	/**
	 * Visar förstasidan när man är inloggad.
	 */
	public function showHomePage($username){
		
		echo $this->masterView->basicHeader() .   
		"<h1>Laboration 4</h1>
				<h2>$username är inloggad</h2>
				 	 <a href='?".$this->logout."'>Logga ut</a>"
				 .$this->message
				 . $this->masterView->basicFooter()
				 ;
	}
}
?>