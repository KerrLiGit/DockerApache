<?php
	require "lib.php";
	safe_session_start();   

	$surname = $_POST['surname'];
	$name = $_POST['name'];
	$secname = $_POST['secname'];
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$role = "student";                        
	$classid = $_POST['class'];

	$mysqli = get_sql_connection();

	$class = $mysqli->prepare("SELECT classnum, classlit FROM class WHERE classid = ?");
	$class->bind_param("i", $classid);
	if (!$class->execute()) {
		$_SESSION['message-auth'] = "Ошибка сервера. " . $mysqli->error;
		header('Location: ../login.php');
		return;
	}
	$classres = $class->get_result()->fetch_row();
	if (empty($classres)) {
		$_SESSION['message-auth'] = "Класс не найден.";
		header('Location: ../login.php');
		return;
	}
	$classnum = $classres[0];
	$classlit = $classres[1];

	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM account WHERE login = ?");
        $stmt->bind_param("s", $login);
	if (!$stmt->execute()) {
		$_SESSION['message-auth'] = "Ошибка сервера. " . $mysqli->error;
		header('Location: ../login.php');
		return;	
	}
	if ($stmt->get_result()->fetch_row()[0] > 0) {
		$_SESSION['message-auth'] = "Такой логин уже существует.";
		header('Location: ../login.php');
		return;
	}

	$stmt = $mysqli->prepare("INSERT INTO account (role, login, `password`, surname, name, secname, classnum, classlit) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssis", $role, $login, $pass, $surname, $name, $secname, $classnum, $classlit);
	if (!$stmt->execute()) {
		$_SESSION['message-auth'] = "Ошибка регистрации. " . $mysqli->error;
		header('Location: ../login.php');
		return;
	}
	$_SESSION['message-auth'] = '';
	$_SESSION['message-auth'] = "Успешная регистрация. Ожидайте подтверждения аккаунта учителем." . $mysqli->error;
	header('Location: ../login.php');			
?>
