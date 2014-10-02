<?php

namespace controller;

require_once('model/RegisterModel.php');
require_once('view/RegisterView.php');
require_once('TooShortCredentialsException.php');

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
			
			// Get user input from the view and send it to the registerModel
			try {
				if($this->registerModel->createUser($this->registerView->getUsername(),
													$this->registerView->getPassword(),
													$this->registerView->getRepeatedPassword())) {

					\view\SharedView::saveNewUserName($this->registerView->getUsername());
					\view\SharedView::activateSuccessMessage();

					$this->registerView->getLoginPage();
				}
			} catch(\TooShortCredentialsException $e) {
				foreach($e->getMessageArray() as $message)
					$this->registerView->setRegistrationErrorMessage($message);
			} catch (\Exception $e) {
				$this->registerView->setRegistrationErrorMessage($e->getMessage());
			}
		}

		//Generate output-HTML
		$this->registerView->getRegisterHTML();
	}
}