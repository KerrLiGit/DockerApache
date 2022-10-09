<?php
	require "lib.php";

	$mysqli = get_sql_connection();
	$datefrom = $_POST['datefrom'] . ' 00:00:00';
	$dateto = $_POST['dateto'] . ' 23:59:59';
	$action = $_POST['action'];
	
	safe_session_start();
	if (isset($_SESSION['logs'])) {
		unset($_SESSION['logs']);
	}
	$_SESSION['logs'] = array();	
	
	if ($action == 'all') {
		$stmt = $mysqli->prepare("SELECT * FROM `log` WHERE eventdate >= ? AND eventdate <= ?");
		$stmt->bind_param("ss", $datefrom, $dateto);
	}
	else {
		$stmt = $mysqli->prepare("SELECT * FROM `log` WHERE eventdate >= ? AND eventdate <= ? AND action = ?");
		$stmt->bind_param("sss", $datefrom, $dateto, $action);
	}
	$stmt->execute();
	$result = $stmt->get_result();
	$log = $result->fetch_assoc();
	while (!is_null($log)) {
		$_SESSION['logs'][] = $log;
		$log = $result->fetch_assoc();
	}           
	header('Location: ../admin.php');
?>