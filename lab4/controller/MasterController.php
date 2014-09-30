<?php

namespace controller;

require_once('view/SharedView.php');
require_once('controller/RegisterController.php');
require_once('controller.php');

class MasterController {

	public function applicationRouter() {
		if(\view\SharedView::wantToRegister())
			(new \controller\RegisterController())->doRegister();
		else
			(new \controller\controller());
	}
}