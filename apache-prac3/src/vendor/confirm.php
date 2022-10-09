<?php
	require "lib.php";

	$mysqli = get_sql_connection();
	$stmt = $mysqli->prepare('UPDATE account SET confirm = 1 WHERE login = ?');
	$login = $_POST['login'];
	$stmt->bind_param('s', $login);
	if (!$stmt->execute()) {
		//
	}
	else {
		header('Location: ../office.php#confirm');
	}
?>