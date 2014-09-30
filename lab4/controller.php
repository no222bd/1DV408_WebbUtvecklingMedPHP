<?php
    
namespace controller;

// no222bd - Added TextScrambler ==================================================================
require_once('model/TextScramblerModel.php');

require_once 'view.php';
require_once 'model.php';

class Controller{
	
	/**
	 *  Objekt av klassen View.
	 */
	private $classView;
	
	/**
	 * Objekt av klassen Model.
	 */
	private $classModel;

	public function __construct(){

		$this->classView = new \view\View();
		$this->classModel = new \model\Model();
		
		$this->checkLogin();
	}
	
	/**
	 * Kontrollerar sessionen och kakorna
	 * och avgör vad som ska visas.
	 */
	private function checkLogin(){

		$this->classModel->checkSession();
		
		if(!$this->classModel->isUserLoggedIn()){
			$this->checkCookie();
		}

		$this->checkLogoutButton();
		
		if(!$this->classModel->isUserLoggedIn()){
			$this->tryToLogin();
		}
		
		if($this->classModel->isUserLoggedIn()){
			$this->showHomePage();
		}	
		
		if(!$this->classModel->isUserLoggedIn()){
			$this->showLoginPage();	
		}
	}
	
	/**
	 * Kontrollerar ifall kakorna är giltiga
	 * och om de är det startas sessionen.
	 */
	// no222bd - Rewritten checkCookie function and added checkCredentials function ==============================
	private function checkCookie(){

		if($this->classView->cookieExist()){


			//var_dump($this->classView->checkCookieTime());
			//(var_dump($this->classModel->checkCredentials($this->classView->getUsernameCookie(), \model\TextScramblerModel::decrypt($this->classView->getPasswordCookie()))); die();

			if($this->classView->checkCookieTime()
			   && $this->classModel->checkCredentials($this->classView->getUsernameCookie(), 
												      \model\TextScramblerModel::decrypt($this->classView->getPasswordCookie()))) {

			// Old code -- if(!$this->classView->checkCookie($this->classModel->getAdmin(), $this->classModel->getCookiePass(), $this->classModel->getSalt())){

				$this->classModel->startSession();
				$this->classView->setMessage(\view\View::COOKIE);
			} else {
				$this->classView->destroyCookie();
				$this->classView->setMessage(\view\View::WRONG_COOKIE);
			}
		}
	}
	/*private function checkCookie(){

		if($this->classView->cookieExist()){

			if($this->classView->checkCookieTime()
			   && $this->classModel->checkCredentials($this->classView->getUsernameCookie(), 
												      \model\TextScramblerModel::decrypt($this->classView->getPasswordCookie()))) {
			
			// Old code -- if(!$this->classView->checkCookie($this->classModel->getAdmin(), $this->classModel->getCookiePass(), $this->classModel->getSalt())){

				$this->classView->destroyCookie();
				$this->classView->setMessage(\view\View::WRONG_COOKIE);
			}
			else{
				$this->classModel->startSession();
				$this->classView->setMessage(\view\View::COOKIE);
			}
		}
	}*/
	/**
	 * Utförs när användaren försöker logga ut.
	 * Avslutar kakorna och sessionen.
	 */
	private function checkLogoutButton(){
		
		if($this->classView->tryToLogOut() && $this->classModel->isUserLoggedIn()){
			$this->classView->setMessage(\view\View::LOGGED_OUT);
			
			if($this->classView->cookieExist()){
				$this->classView->destroyCookie();
			}
			$this->classModel->destroySession();
		}
	}
	
	/**
	 * Utförs när användaren försöker logga in.
	 * Skapar session och kakor om användaren valt detta.
	 */
	// no222bd - Rewritten the call to bakeCookies() so that Username and password 
	//		     comes from $_POST instead of from hardcoded values
	private function tryToLogin(){
		
		if($this->classView->tryToLogin()){

			if($this->checkUserInput()){

				if($this->classView->getLoginBox()){
					$this->classView->setMessage(\view\View::LOGGED_IN_AND_REMEMBER_YOU);
					
					if(!$this->classView->cookieExist()) {
						$this->classView->bakeCookie($this->classView->getUserName(),
													 \model\TextScramblerModel::encrypt($this->classView->getPassword()));

						// Old invocation of bakeCookie
						//$this->classView->bakeCookie($this->classModel->getAdmin(), $this->classModel->getCookiePass(), $this->classModel->getSalt());
					}
					$this->classModel->startSession();
				}
				else{
					$this->classView->setMessage(\view\View::LOGGED_IN);
					$this->classModel->startSession();
				}
			}
		}
	}
	
	/**
	 * @return bool
	 * Kontrollerar vad användaren matat in.
	 */
	// no222bd - Deleted and Rewritten code ==================================================================
	private function checkUserInput(){
		/*if($this->checkUserName() && $this->checkPassword()){
			return true;
		}
		return false;*/

		if($this->checkUserName() && $this->checkPassword()){

			//echo "hej"; die();


			if($this->classModel->checkCredentials($this->classView->getUserName(), $this->classView->getPassword())) {
		 		return true;
		 	} else {
				$this->classView->setMessage(\view\View::BOTH_WRONG);
				return false;
			}
		}
	}

	/**
	 * @return bool
	 * Kontrollerar användarnamnet som användaren matat in.
	 */
	private function checkUserName(){

		if($this->classView->getStripUserName() == null){
			$this->classView->setMessage(\view\View::USERNAME_EMPTY);
			return false;
		}

		if($this->classView->getUserName() !== $this->classView->getStripUserName()){
			$this->classView->setMessage(\view\View::NO_TAGS);
			return false;
		}

		// no222bd - Deleted code ============================================================
		/*if($this->classView->getStripUserName() == $this->classModel->getAdmin()){
			return true;
		} else {
			$this->classView->setMessage(\view\View::BOTH_WRONG);
			return false;
		}*/

		return true;
	}
	
	/**
	 * @return bool
	 * Kontrollerar lösenordet som användaren matat in.
	 */
	private function checkPassword(){
		
		if($this->classView->getStripPassword() == null){
			$this->classView->setMessage(\view\View::PASSWORD_EMPTY);
			return false;
		}
		
		if($this->classView->getPassword() !== $this->classView->getStripPassword()){
			$this->classView->setMessage(\view\View::NO_TAGS);
			return false;
		}

		// no222bd - Deleted code ===========================================================
		/*if($this->classView->getStripPassword() == $this->classModel->getPassword()){
			return true;
		}
		else{
			$this->classView->setMessage(\view\View::BOTH_WRONG);
			return false;
		}*/
		return true;
	}
	
	/**
	 * Visas om användaren "inte" är inloggad.
	 */
	private function showLoginPage(){
		
		$this->classView->showLoginPage();
	}
	
	/**
	 * Visas om användaren "är" inloggad
	 */
	private function showHomePage(){
		
		$this->classView->showHomePage($this->classModel->getCurrentUsername());
	}
}
?>