<?php
include_once("./app/view/admin.php");
//include_once("./app/view/admin.php");
class adminController extends basicContoller {	
	private $active = false;
	
	function run() {		
		if("logoff" === indexController::param(1)) {
			indexController::logoff();
		}
		else {
			if (indexController::submit()) {
				if(!indexController::logon($_POST["login"], $_POST["pass"])) {
					$this->active = true;
					indexController::message('<div class="alert alert-danger" role="alert">Ошибка авторизации</div>');
				}
			}
			else $this->active = true;
			if($this->active) {				
				$view = new adminView();
				$view->render();
			}
		}
	}
	
	function active() {
		return $this->active;
	}
}
?>