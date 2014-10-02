<?php

namespace view;

require_once('view/SharedView.php');

class RegisterView {
	
	private static $username = 'username';
	private static $password = 'password';
	private static $repeatedPassword = 'repeatedPassword';
	private static $registerButton = 'registerButton';

	private $registrationErrorMessage = array();

	public function doRegister(){
		return isset($_POST[self::$registerButton]);
	}

	public function getUsername(){
		return $_POST[self::$username];
	}

	public function getPassword(){
		return $_POST[self::$password];
	}

	public function getRepeatedPassword(){
		return $_POST[self::$repeatedPassword];
	}

	public function setRegistrationErrorMessage($errorMessage) {
		$this->registrationErrorMessage[] = $errorMessage;
	}

	public function getLoginPage() {
		header('Location: ' . $_SERVER['PHP_SELF']);
	}

	public function getRegisterHTML() {
		
		// Get header HTML from SharedView
		$output = \view\SharedView::basicHeader();
		
		// RegisterHTML	 
		$output .= '
			<h1>Laboration 4</h1>
			<h2>Ej inloggad - Registrera användare</h2>
			<p>
				<a href="?">Tillbaka</a>
			</p>
			<form action="' . $_SERVER['PHP_SELF'] . '?' . \view\SharedView::$registerURL . '" method="post">
				<fieldset>
					<legend>Registrera ny användare</legend>';
		
		// Add errormesseage if exists
		foreach($this->registrationErrorMessage as $message) {
			$output .= '<p>' . $message . '</p>';
		}
		
		$output .= '<label>Namn
					 	<input type="text" name="' . self::$username . '"';

		// Set value of username input tag
		if(isset($_POST[self::$username]))
			$output .= ' value="' . strip_tags($_POST[self::$username]) . '"';

		$output .= '/>
					</label><br/>
					<label>Lösenord
 						<input type="password" name="' . self::$password . '"/>
					</label><br/>
					<label>Repetera lösenord
						<input type="password" name="' .self::$repeatedPassword. '"/>
					</label><br/>
					<input type="submit" name="' . self::$registerButton . '" value="Registrera"/>
				</fieldset>
			</form>';

		// Get footer HTML from SharedView
		$output .= \view\SharedView::basicFooter(); 
		
		echo $output;
	}
}