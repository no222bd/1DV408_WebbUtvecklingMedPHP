<?php

class TooShortCredentialsException extends Exception {

	private $messageArray = array(); 

	public function __construct($tooShortUsernameMsg, $tooShortPasswordMsg) {
		$this->messageArray[] = $tooShortUsernameMsg;
		$this->messageArray[] = $tooShortPasswordMsg;
	}

	public function getMessageArray() {
		return $this->messageArray;
	}
}