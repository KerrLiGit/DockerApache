<?php
	require "lib.php";

	$mysqli = get_sql_connection();
	$class = $_POST['class'];
	$num = $_POST['num'];
	$type = $_POST['type'];
	$title = $_POST['title'];
	$subtitle = $_POST['subtitle'];
	$content = $_POST['content'];
	$hidden = $_POST['hidden'];
	if ($type != "olymp" && $class < 5) {
		echo "Данная задача не будет отображаться на сайте";
		//header('Location: ../office.php#create');
		return;
	}
	$stmt = $mysqli->prepare('SELECT count(*) FROM topic WHERE classnum = ? AND topicnum = ? AND type = ?');
	$stmt->bind_param('iis', $class, $num, $type);
	if (!$stmt->execute()) {
		echo $mysqli->error;
		return;
	}        
	if ($stmt->get_result()->fetch_row()[0] == 0) {
		$stmt->prepare('INSERT INTO topic (classnum, topicnum, type, title, subtitle, content, hidden) VALUES (?, ?, ?, ?, ?, ?, ?)');
		$stmt->bind_param('iisssss', $class, $num, $type, $title, $subtitle, $content, $hidden);
		if (!$stmt->execute()) {
			echo $mysqli->error;
			return;
		}
	}
	else {
		$stmt->prepare('UPDATE topic SET title = ?, subtitle = ?, content = ?, hidden = ? WHERE classnum = ? AND topicnum = ? AND type = ?');
		$stmt->bind_param('ssssiis', $title, $subtitle, $content, $hidden, $class, $num, $type);
		if (!$stmt->execute()) {
			echo $_POST['hidden'] . "++";
			echo $mysqli->error;
			return;
		}
	}
	header('Location: ../office.php#create');
?>