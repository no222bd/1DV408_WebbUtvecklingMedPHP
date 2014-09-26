<?php

namespace controller;

require_once('/view/SharedView.php');
require_once('/controller.php');
require_once('/controller/RegisterController.php');

class MasterController {
	
	//private $masterView;

	//public function __construct() {
	//	$this->masterView = new \view\MasterView();
	//}

	public function applicationRouter() {
		if(\view\SharedView::wantToRegister())
			(new \controller\RegisterController())->doRegister();
		else
			(new \controller\controller());
	}
}