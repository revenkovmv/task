<?php
include_once("./app/model/home.php");
include_once("./app/view/home.php");

class homeController extends basicContoller {
	function run() {
		$res = null === indexController::paramByName("add");
		if(!$res) {
			if(indexController::submit()) {
				$model = new Tasks();
				$res = $model->add($_POST["username"], $_POST["email"], $_POST["text"]);				
			} 
			else $model = null;			
			if(!$res) {
				$view = new tasksView();
				$view->add($model);
			}
		}
		if($res) {
			$model = new Tasks();
			if(indexController::logged()&&indexController::paramByName("id")) {
				$model->update(indexController::paramByName("id"));
			}
			$sort = indexController::paramByName("sort");
			switch ($sort) {
				case "email": 
				case "status": 
				case "username": 
				case "email_desc": 
				case "status_desc": 
				case "username_desc": 
					break;
				default: 
					$sort="id desc";
			}
			$page = indexController::paramByName("page");
			if(!$page) $page = 0;
			$model->fetchRows($sort, true, $page);
			$view = new tasksView();
			$view->render($model);
		}
	}
}
?>