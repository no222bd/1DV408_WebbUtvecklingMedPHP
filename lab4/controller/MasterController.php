<?php

namespace controller;

require_once('/view/MasterView.php');
require_once('/controller.php');
require_once('/controller/RegisterController.php');

class MasterController {
	
	private $masterView;

	public function __construct() {
		$this->masterView = new \view\MasterView();
	}

	public function applicationRouter() {
		if($this->masterView->wantToRegister())
			(new \controller\RegisterController())->doRegister();
		else
			(new \controller\controller());
	}
}