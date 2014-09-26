<?php

namespace view;

require_once('/view/MasterView.php');

class RegisterView {
	
	private $masterView;

	private $username = 'username';
	private $password = 'password';
	private $repeatedPassword = 'repeatedPassword';
	private $registerButton = 'registerButton';

	private $registrationErrorMessage = array();


	public function __construct() {
		$this->masterView = new \view\MasterView();
	}

	public function doRegister(){
		return isset($_POST[$this->registerButton]);
	}

	public function getUsername(){
		//if(isset($_POST[$this->username])){
			return $_POST[$this->username];
		//}
	}

	public function getPassword(){
		//if(isset($_POST[$this->password])){
			return $_POST[$this->password];
		//}
	}

	public function getRepeatedPassword(){
		//if(isset($_POST[$this->repeatedPassword])){
			return $_POST[$this->repeatedPassword];
		//}
	}

	public function setRegistrationErrorMessage($errorMessage) {
		$this->registrationErrorMessage[] = $errorMessage;
	}

	public function getRegisterHTML() {
		
		$output = $this->masterView->basicHeader();
			 
		$output .= '
			<h1>Laboration 4</h1>
			<h2>Ej inloggad - Registrera användare</h2>
			<p>
				<a href="?">Tillbaka</a>
			</p>
			<form action="' . $_SERVER['PHP_SELF'] . '?register' . '" method="post">
				<fieldset>
					<legend>Registrera ny användare</legend>';
		
		foreach($this->registrationErrorMessage as $message) {
			$output .= '<p>' . $message . '</p>';
		}
		
		$output .= '<label>Namn
					 	<input type="text" name="' . $this->username . '"';

		if(isset($_POST[$this->username]))
			$output .= ' value="' . $_POST[$this->username] . '"';

		$output .= '/>
					</label><br/>
					<label>Lösenord
 						<input type="password" name="' . $this->password . '"/>
					</label><br/>
					<label>Repetera lösenord
						<input type="password" name="' .$this->repeatedPassword. '"/>
					</label><br/>
					<input type="submit" name="' . $this->registerButton . '" value="Registrera"/>
				</fieldset>
			</form>';

		$output .= $this->masterView->basicFooter(); 
		
		echo $output;
	}
}