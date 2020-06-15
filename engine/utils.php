<?php
define ("DEBUG_MODE", true);

function __test($data) {
	if(!DEBUG_MODE)return;
	print_r($data);
	print "<hr>";
}

function __testEx($name, $data) {
	if(!DEBUG_MODE)return;
	print $name.":&nbsp;";
	print_r($data);
	print "<hr>";
}

function __escape($str) {
	return htmlspecialchars($str);
}

function __escapeMySQL($str) {	
	$res = str_replace('‘', "'", $str);
	$res = str_replace('’', "'", $res);
	//$res = dbConnection::escape($res);
	//__test($res);
	return $res;
}
?>