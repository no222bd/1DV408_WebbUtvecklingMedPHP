<?php

namespace controller;

require_once('/model/RegisterModel.php');
require_once('/view/RegisterView.php');

class RegisterController {
	
	private $registerView;
	private $registerModel;

	public function __construct() {
		$this->registerModel = new \model\RegisterModel();
		$this->registerView = new \view\RegisterView();
	}

	public function doRegister() {
		
		// If user has pressed the Register-button
		if($this->registerView->doRegister()) {
			
			// Get user input from the view and send it to the model
			try {
				$this->registerModel->createUser($this->registerView->getUsername(),
												 $this->registerView->getPassword(),
												 $this->registerView->getRepeatedPassword());
			} catch(\Exception $e) {
				$this->registerView->setRegistrationErrorMessage($e->getMessage());
			}
		}
		//Generate output
		$this->registerView->getRegisterHTML();
	}
}