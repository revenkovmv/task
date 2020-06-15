<?php
class indexController extends basicStaticObject {
	use basicControllerIndex;
	
	public static $db_host = "localhost";
	public static $db_login = "root";
	public static $db_pass = "Xt3Q7a2R";
	public static $db_dbname = "task";
	
	public static $messages = array();
	
	public static function init() {
		//self::setRoot("/task/");
		self::initTrait();
	}
	
	function logged() {
		if (isset($_SESSION['__logged']) && $_SESSION["__logged"] == 1) return true;
		else return false;
	}
	
	function logon($username, $password) {
		if("admin" === $username && "123" == $password) {
			$_SESSION["__logged"] = 1;
			return true;
		}
	}
	
	function logoff() {
		$_SESSION["__logged"] = 0;
	}
	
	/*
	Необходимо создать приложение-задачник.

	Стартовая страница - список задач с возможностью сортировки по имени пользователя, email и статусу. Вывод задач нужно сделать страницами по 3 штуки (с пагинацией). Видеть список задач и создавать новые может любой посетитель без авторизации.
	Сделайте вход для администратора (логин "admin", пароль "123"). Администратор имеет возможность редактировать текст задачи и поставить галочку о выполнении. Выполненные задачи в общем списке выводятся с соответствующей отметкой.

В приложении нужно с помощью чистого PHP реализовать модель MVC. Фреймворки PHP использовать нельзя, библиотеки - можно. Этому приложению не нужна сложная архитектура, решите поставленные задачи минимально необходимым количеством кода. Верстка на bootstrap, к дизайну особых требований нет.
*/
	
	public static function run() {		
		//__testEx('self::$params', self::$params);		
		switch(self::param(0)) {
			case "admin":							
				include_once("./app/controller/admin.php");
				$controller = new adminController("admin");
				$controller->run();
				if($controller->active()) break;
			default:
				include_once("./app/controller/home.php");
				$controller = new homeController("home");
				$controller->run();
		}		
	}
	
	public static function message($msg){
		self::$messages []= $msg;
	}
	
	public static function renderMessages() {
		foreach(self::$messages as $msg) echo $msg;
	}
	
}
?>