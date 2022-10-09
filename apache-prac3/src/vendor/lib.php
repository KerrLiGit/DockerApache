<?php
	function safe_session_start() {
		if(!isset($_SESSION))
			session_start(); 
	}

	class xmysqli extends mysqli {
        	function __construct($host, $mylogin, $mypass, $dbname, $login) {
        		@parent::__construct($host, $mylogin, $mypass, $dbname, 3306, false);
        		
        		if (mysqli_connect_errno()) // check if a connection established
				throw new exception(mysqli_connect_error(), mysqli_connect_errno());
			
			if (!is_null($login)) {
				$session = $this->thread_id;
				$stmt = $this->prepare('DELETE FROM `session` WHERE `session` = ?;');
				$stmt->bind_param("i", $session);
				$stmt->execute();
				$stmt = $this->prepare('INSERT INTO `session` (`session`, login) VALUES (?, ?);');
				$stmt->bind_param("is", $session, $login);
				$stmt->execute();
			}
		}

		function __destruct() {
			$idconn = $this->thread_id;
			$stmt = $this->prepare('DELETE FROM `session` WHERE `session` = ?;');
			$stmt->bind_param("i", $idconn);
			$stmt->execute();
		}
	}

	function get_sql_connection() {
		safe_session_start();
		$login = NULL;
		if (array_key_exists('user', $_SESSION))
			$login = $_SESSION['user']['login'];
		//$mysqli = new mysqli("localhost", "u133692_root", "root", "u133692_teacherbase"); // исп. постоянные соединения
		$mysqli = new xmysqli("p:mysql", "root", "root", "teacherbase", $login); // исп. постоянные соединения
		//$mysqli = new mysqli("mysql", "root", "root", "appDB"); // исп. постоянные соединения
		$mysqli->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
		return $mysqli;
	}

        function session_message($key) {
		safe_session_start();
		$str = "";
		if (array_key_exists($key, $_SESSION)) {
	        	$str = $_SESSION[$key];
		        unset($_SESSION[$key]);
		}
		return $str;
	}

	function admin_access() {
		if (!array_key_exists('user', $_SESSION))
			return false;          
		if ($_SESSION['user']['role'] == 'admin') 
			return true;
		return false;
	}

	function teacher_access() {
		if (!array_key_exists('user', $_SESSION))
			return false;          
		if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'teacher') 
			return true;
		return false;
	}

	function student_access($num) {
		if (!array_key_exists('user', $_SESSION))
			return false;                    
		if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'teacher') 
			return true;
		/*if ($_SESSION['user']['role'] == 'student' && $num == 0)
			return true;*/
		if ($_SESSION['user']['role'] == 'student' && $_SESSION['user']['classnum'] == $num)
			return true;
		return false;
	}
?>