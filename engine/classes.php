<?php
include_once("./engine/utils.php");

class basicObject {
	public function set($name, $val) {
		$this->$name = $val;
	}	
}

class basicStaticObject extends basicObject {
	public function set($name, $val) {
		self::$$name = $val;
	}
}

class basicContoller extends basicObject {
	protected $module = "";
	
	function __construct($module) {
		$this->module = $module;
	}
}

trait basicControllerIndex {
	public function set($name, $val) {
		self::$$name = $val;
	}
	
	private static $params = array();
	protected static $root = "";
	
	private static function setRoot($root) {
		self::$root = $root;
	}
	
	public static function param($id) {
		if (count(self::$params) > $id) return self::$params[$id];
		else return "";
	}
	
	public static function setParam($id, $value) {
		if (count(self::$params) > $id) self::$params[$id] = $value;
		else {
			while (count(self::$params) < $id) self::$params []= "";
			self::$params []= $value;
		}
	}

	public static function paramByName($name) {
		for($i=0; $i<count(self::$params); $i++) {
			if (self::$params[$i] == $name) {
				return self::param($i+1);
			}
		}
		return null;
	}
	
	private static function initTrait() {
		$s = explode (self::$root , $_SERVER["REQUEST_URI"] , 2) ;
		if (count($s) > 1) $s = $s[1];
		else $s = "";
		self::$params = explode("/", $s);
	}
	
	public static function run() {
	}

	public static function getUrl($ref = "") {
		return self::$root.$ref;
	}
	
	public static function submit() {
		if($_SERVER['REQUEST_METHOD']=='POST') return true;
		else return false;
	}
}

class basicModel extends basicObject {
	
}

class basicView extends basicObject {
	
}

class dbConnection {
	private static $link;
	
	public static function connect($host, $username, $password, $dbname) {
		self::$link = mysqli_connect($host, $username, $password, $dbname);
		if(self::$link) return true;
		else return false;
	}
	
	public static function query($sql) {
		$result = mysqli_query(self::$link, $sql);
		$res = array();		
		while ($row = mysqli_fetch_array($result)) {
			$res []= $row;
		}
		return $res;
	}
	
	public static function queryRow($sql) {
		$result = mysqli_query(self::$link, $sql);
		if ($row = mysqli_fetch_array($result)) {
			return $row;
		}
		return array();
	}
	
	public static function exec() {
		$result = mysqli_query(self::$link, $sql);
		if($result) return true;
		else return false;
	}
	
	public static function prepare($sql) {
		return mysqli_prepare(self::$link, $sql);
	}
	
	public static function escape($str) {
		return mysqli_real_escape_string (self::$link , $str );
	}
	
	public static function lastError() {
		return mysqli_errno(self::$link);
	}
}
?>