<?php
class Tasks extends basicModel {	
	public $data;
	public $count = 0;
	public $page = 0;
	public $perPage = 0;
	
	public function fetchRows($sortBy, $paged = false, $page = 0, $perPage = 3) {
		dbConnection::connect(indexController::$db_host, indexController::$db_login, indexController::$db_pass, indexController::$db_dbname);
		$tmp = dbConnection::queryRow("select count(id) as cnt from tasks");
		$this->count = $tmp["cnt"];
		if($paged) {
			if($page > 0) $sql = (($page - 1) * $perPage).", ";
			else $sql = "";
			$sql = "LIMIT $sql $perPage";
		} else $sql = "";
		$sortBy = str_replace("_", " ", $sortBy);
		if("" !== $sortBy) $sql = "ORDER BY $sortBy $sql";
		$sql = "select * from tasks $sql";
		//__testEx("sql", $sql);		
		$this->data = dbConnection::query($sql);
	}
	
	public function add($username, $email, $text) {
		$this->data = array(
			"username" => __escape($username), 
			"email" => __escape($email), 
			"text" => __escape($text)
		);
		if("" === $this->data["username"]) {
			indexController::message('<div class="alert alert-danger" role="alert">Имя пользователя не может быть пустым</div>');
			return false;
		}
		if(!filter_var($this->data["email"], FILTER_VALIDATE_EMAIL)) {
			indexController::message('<div class="alert alert-danger" role="alert">Недопустимое представление email</div>');
			return false;
		}
		if("" === $this->data["text"]) {
			indexController::message('<div class="alert alert-danger" role="alert">Текст задачи не может быть пустым</div>');
			return false;
		}
		dbConnection::connect(indexController::$db_host, indexController::$db_login, indexController::$db_pass, indexController::$db_dbname);
		$res = dbConnection::prepare("insert into tasks values(null, ?, ?, ?, 0)");
		mysqli_stmt_bind_param($res, "sss", $username, $email, $text);
		$username = __escapeMySQL($this->data["username"]);
		$email = __escapeMySQL($this->data["email"]);
		$text = __escapeMySQL($this->data["text"]);
		$res = mysqli_stmt_execute($res);
		if(!$res) indexController::message('<div class="alert alert-danger" role="alert">Не удалось добавить запись</div>');
		return $res;
	}
	
	public function update($id) {
		dbConnection::connect(indexController::$db_host, indexController::$db_login, indexController::$db_pass, indexController::$db_dbname);
		$res = dbConnection::prepare("update tasks set status = (status + 1) mod 2 where id=?");
		mysqli_stmt_bind_param($res, "s", $_id);
		$_id = $id;
		return mysqli_stmt_execute($res);
	}
}
?>