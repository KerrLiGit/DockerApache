<?php
	require "lib.php";
	safe_session_start();   	                   	

	$login = $_POST['login'];
	$pass = $_POST['pass'];
	//$pass = md5($_POST['pass']);
	$mysqli = get_sql_connection();
	$stmt = $mysqli->prepare("SELECT * FROM account WHERE login = ? AND `password` = ? AND confirm = 1");
	$stmt->bind_param("ss", $login, $pass);
	$stmt->execute();
	$check = $stmt->get_result();
	if (mysqli_num_rows($check) > 0) {	
		$user = $check->fetch_assoc();
		$_SESSION['user'] = [
			"login" => $user['login'],
			"surname" => $user['surname'],
			"name" => $user['name'],
			"secname" => $user['secname'],
			"role" => $user['role'],
			"classnum" => $user['classnum'],
			"classlit" => $user['classlit'],
		];
		header('Location: ../index.php');
		//$_SESSION['message-auth'] = 'Успешный вход.';
		$_SESSION['message-auth'] = '';	
	}
	else {
		header('Location: ../signin.php');
		$_SESSION['message-auth'] = 'Неверный пароль!';
	}
?>