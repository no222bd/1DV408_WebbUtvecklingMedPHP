<?php

namespace view;

class SharedView {

	private static $cookieLocation = 'message';
	private static $newUserLocation = 'newUserName';
	public static $registerURL = 'register';

	// ========== no222bd - Check to decide wich usecase to run ==========
	public static function wantToRegister(){
		return array_key_exists(self::$registerURL, $_GET);
	}

	// ========== no222bd - Save message to cookie ==========
	public static function activateSuccessMessage() {
		setcookie(self::$cookieLocation, 'Registrering av ny användare lyckades', 0);
	}

	// ========== no222bd - Return message from cookie and remove the cookie ==========
	public static function getSuccessMessage() {
		if(isset($_COOKIE[self::$cookieLocation])) {
			$msg = $_COOKIE[self::$cookieLocation];
			setcookie(self::$cookieLocation, '', time() - 1);
			return '<p>' . $msg . '</p>';
		}
	}			

	// ========== no222bd - Save username to cookie ==========
	public static function saveNewUserName($username) {
		setcookie(self::$newUserLocation, $username, 0);
	}

	// ========== no222bd - Return username and remove the cookie ==========
	public static function getNewUserName() {
		if(isset($_COOKIE[self::$newUserLocation])) {
			$msg = $_COOKIE[self::$newUserLocation];
			setcookie(self::$newUserLocation, '', time() - 1);
			return $msg;
		}
	}

	// ========== no222bd - Moved and rewritten from view.php ==========
	public static function basicHeader() {

		return '<!doctype html>
			<html lang="sv">
			<head>
				<meta charset="utf-8"/>
				<title>Laboration 4</title>
			</head>
				<body>';
	}
	/*public function basicHeader(){

		return "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'> 
        <html  xmlns='http://www.w3.org/1999/xhtml'> 
          <head> 
             <title>Laboration 4</title> 
             <meta http-equiv='content-type' content='text/html; charset='utf-8'/>
          </head> 
          <body>";
	}*/
	
	// ========== no222bd - Moved and rewritten from view.php ==========
	public static function basicFooter() {
		return '<p>' . ucfirst(utf8_encode(strftime('%A'))) . strftime(', den %#d ') . ucfirst(strftime('%B'))
			   		 . strftime(' år %Y. Klockan är [%H:%M:%S].') . '</p>
			   	</body>
			   	</html>';
	}
	/**!!!NOTERA!!!
	 * hour date + 2 är en åtgärd som är nödvändig på webbhotelets server.
	 * Klockan fungerar korrekt utom timmar som visade två timmar för tidigt.
	 * Och dagen som inte kan ta åäö.
	 * Skulle webbhotel bytas eller testas localt kan denna åtgärd kanske tas bort.
	 */
	/*public function basicFooter(){
			
		$hour = date("H") + 2;
		
		$showDay = "<p> ".strftime('%A');
		
		$showCorrectDay = utf8_encode($showDay);
		
		return $showCorrectDay . strftime('den %d %B år %Y. Klockan är: ['. $hour .':%M:%S] ')."</p></body> </html>";

	}*/
	
}