<?php
	function safe_session_start() {
		if(!isset($_SESSION))
			session_start(); 
	}

	function get_sql_connection() {
		$mysqli = new mysqli("mysql", "root", "root", "appDB"); // исп. постоянные соединения
		$mysqli->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
		return $mysqli;
	}
?>
