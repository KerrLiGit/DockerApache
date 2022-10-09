<?php
	require "lib.php";

	$mysqli = get_sql_connection();
	$stmtclass = $mysqli->prepare('SELECT a.login FROM account a LEFT JOIN class c ON (a.classnum = c.classnum AND a.classlit = c.classlit) 
		WHERE a.confirm = 1 and a.role = "student" AND c.classid = ?');
	$classid = $_POST['classid'];
	$stmtclass->bind_param("i", $classid);
	if (!$stmtclass->execute()) {
		// ОШИБКА
		return;
	}
	$res = $stmtclass->get_result();
	$logins = array();
	while ($login = $res->fetch_row()) {
		$logins[] = $login[0];
	}
	$class = $_POST['class'];
	$num = $_POST['num'];
	$type = $_POST['type'];
	$deadline = $_POST['deadline'];
	for ($i = 0; $i < count($logins); $i++) {
		$login = $logins[$i];
		$stmt = $mysqli->prepare("SELECT count(*) FROM link WHERE login = ? AND classnum = ? AND topicnum = ? AND type = ?");
		$stmt->bind_param("siis", $login, $class, $num, $type);
		if (!$stmt->execute()) {
			// ОШИБКА
			return;
		}
		if ($stmt->get_result()->fetch_row()[0] != 0) {
			$stmt = $mysqli->prepare("UPDATE link SET deadline = ? WHERE login = ? AND classnum = ? AND topicnum = ? AND type = ?");
			$stmt->bind_param("ssiis", $deadline, $login, $class, $num, $type);
			if ($stmt->execute()) {
				//header('Location: ..' . $_POST['url']);
			}
		}
		else {
			$stmt = $mysqli->prepare("INSERT INTO link (login, classnum, topicnum, type, deadline) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("siiss", $login, $class, $num, $type, $deadline);
			if ($stmt->execute()) {
				//header('Location: ..' . $_POST['url']);
			}
		}
	}
	header('Location: ..' . $_POST['url']);
?>