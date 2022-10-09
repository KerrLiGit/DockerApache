<?php
require "vendor/lib.php";
safe_session_start();
global $CLASSNUM;
$CLASSNUMS = $_GET['class'];
global $TYPE;
$TYPE = $_GET['type'];
?>

<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Сайт Екатерины Анощенковой</title>
	<link rel="stylesheet" href="css\style.css">
	<link rel="stylesheet" href="css\navbar.css">
        <link rel="stylesheet" href="css\anchor.css">       
	<script src="js\navbar.js"></script>
	<link type="image\x-icon" href="img\back_round.jpg" rel="shortcut icon">
    	<link type="Image\x-icon" href="img\back_round.jpg" rel="icon">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body onLoad="onResize()">

<menu id="content">
	<div class="box1"><a class="nava" href="index.php"><name style="font-size: 24px;">Екатерина Анощенкова</name><br>учитель&nbsp;математики</a></div>
	<?php
	if (admin_access()) {
		echo '<div class="box2" id="box2_1"><a class="nava" href="admin.php">Система</a></div>';
	}                 
	if (teacher_access()) {
		echo '<div class="box2" id="box2_2"><a class="nava" href="office.php">Кабинет</a></div>';
	} 
	?>                                                                                
	<div class="box2" id="box2_3"><a class="nava" href="learn.php">Обучение</a></div>
	<div class="box2" id="box2_4"><a class="nava" href="olymp.php">Олимпиады</a></div>
	<div class="box2" id="box2_5"><a class="nava" href="about.php">Обо мне</a></div>
	<?php                
	if (array_key_exists('user', $_SESSION)) {
		echo '<div class="box2" id="box2_6"><a class="nava" href="vendor\signout.php">Выйти</a></div>';
	}
	else {
		echo '<div class="box2" id="box2_6"><a class="nava" href="signin.php">Войти</a></div>';
	}
	?>	
</menu>

<div class="box1o" id="btno" onclick="openNav()"><b>&#9776;</b></div>  
<div class="box1c" id="btnc" onclick="closeNav()"><b>&times;</b></div>

<div id="unic_content">
	<div class="anchor_wrapper">
		<nav><div class="anchor_menu" id="anchor_content">
			<?php  
			for ($i = 0; $i < count($CLASSNUMS); $i++) {            
				$CLASSNUM = $CLASSNUMS[$i];
				$mysqli = get_sql_connection();
				$result = $mysqli->query("SELECT topicnum, subtitle FROM topic WHERE classnum = " . $CLASSNUM . " AND type = '" . $TYPE . "'");
				$anchor = $result->fetch_row();
				while ($anchor) {
					echo '<div><a id="panel" href="#lesson' . $anchor[0] . '" style="font-size: 18px; margin-bottom: 10px;">';
					echo $anchor[1] . '</a></div>';
					$anchor = $result->fetch_row();
				}
			}
			?>
		</div></nav>
		<div class="anchor_main">
			<?php
			for ($i = 0; $i < count($CLASSNUMS); $i++) {
				$CLASSNUM = $CLASSNUMS[$i];
				$result = $mysqli->query("SELECT classnum, topicnum, type, title, content, hidden FROM topic WHERE classnum = " . 
					$CLASSNUM . " AND type = '" . $TYPE . "'");
				$anchors = array();
				while ($anchor = $result->fetch_row()) {
					$anchors[] = $anchor;
				}				
				echo '<table border="0px" width="100%">';
				for ($j = 0; $j < count($anchors); $j++) {
					$anchor = $anchors[$j];
					echo '<tr>';
					echo '<td valign="top">';
					echo '<a class="anchor" id="lesson' . $anchor[1] . '"></a>';
					echo '<article>' . $anchor[3] . '</article>';
					echo $anchor[4];
					if (!array_key_exists('user', $_SESSION)){
						echo '<div style="padding-bottom: 10px;"><a href="signin.php">Продолжение после получения доступа у учителя</a></div>';
					}
					else {
						$stmt = $mysqli->prepare('SELECT count(*), deadline FROM link WHERE login = ? AND classnum = ? 
							AND topicnum = ? AND type = ? AND NOW() < deadline');
						$login = $_SESSION['user']['login'];
						$stmt->bind_param("siis", $login, $anchor[0], $anchor[1], $anchor[2]);
						$stmt->execute(); // !!!
						$access = $stmt->get_result()->fetch_row();
						if (teacher_access()) {
							echo '<div style="padding-bottom: 10px;"><a href="">Скрытое содержание</a></div>';
							echo $anchor[5];
						}
						else if ($access[0]) {
							echo '<div style="padding-bottom: 10px;"><a href="">Доступно до ' . 
							$access[1][8] . $access[1][9] . '.' . $access[1][5] . $access[1][6] . '.' . 
							$access[1][0] . $access[1][1] . $access[1][2] . $access[1][3] . '</a></div>';
							echo $anchor[5];
						}
						else {
							echo '<div style="padding-bottom: 10px;"><a href="">Не доступно</a></div>';
						}
					}
					echo '</td>';
					if (teacher_access()) {
						echo '<td valign="top" width="400px" style="padding-left:20px">';
						$students = $mysqli->query('SELECT login, surname, name, secname, classnum, classlit FROM account 
							WHERE confirm = 1 and role = "student"');
						echo '<div style="padding-bottom: 10px;">
							<article>Задать тему</article>
							<form action="vendor/issuetopicstudent.php" method="post">
							<input type="hidden" name="url" value=' . $_SERVER['REQUEST_URI'] . ' required></input>
							<input type="hidden" name="class" value=' . $anchor[0] . ' required></input>
							<input type="hidden" name="num" value=' . $anchor[1] . ' required></input>
							<input type="hidden" name="type" value=' . $anchor[2] . ' required></input>
							<input type="date" name="deadline" title="Сдать до" required></input><br>
							<input type="text" id="studentvalue" title="Поиск" placeholder="Поиск"></input><br>
							<select id="studentselect" name="login" title="Начать вводить имя" required>';
						$student = $students->fetch_row();
						echo '<option></option>';
						while (isset($student)) {
							echo '<option value="' . $student[0] . '">' . $student[1] . ' ' . $student[2] . ' ' . 
							$student[3] . ' ' . $student[4] . $student[5] . '</option>';
							$student = $students->fetch_row();
						}
						echo '</select>&nbsp;<button type="submit" title="Задать урок ученику">Задать</button></form></div>';
						
						$classes = $mysqli->query('SELECT classid, classnum, classlit FROM class ORDER BY classnum, classlit');
						echo '<div style="padding-bottom: 10px;">
							<form action="vendor/issuetopicclass.php" method="post">
							<input type="hidden" name="url" value=' . $_SERVER['REQUEST_URI'] . ' required></input>
							<input type="hidden" name="class" value=' . $anchor[0] . ' required></input>
							<input type="hidden" name="num" value=' . $anchor[1] . ' required></input>
							<input type="hidden" name="type" value=' . $anchor[2] . ' required></input>
							<input type="date" name="deadline" title="Сдать до" required></input><br>
							<select name="classid" required>';
						$class = $classes->fetch_row();
						echo '<option></option>';
						while (isset($class)) {
							echo '<option value="' . $class[0] . '">' . $class[1] . $class[2] . '</option>';
							$class = $classes->fetch_row();
						}
						echo '</select>&nbsp;
							<button type="submit" title="Задать урок классу">Задать</button></form></div>';
						echo '</td>';
					}       	
					echo '</tr>';
				}       
				echo '</table>';   
			}
			?>
		</div>
		<div class="anchor_button"></div>
	</div>
</div>

</body>

<script type='text/javascript'>
	var elems = document.getElementById("studentselect").options;
	var similar = function (A, B) {
		for (var i = 0; i < B.length; i++)
			if (A.charAt(i) != B.charAt(i)) break;
		return i;
	};
	document.getElementById("studentvalue").onkeypress = function (event) {
		var max = 0;
		for (var i = 0; i < elems.length; i++) {
			var A = elems[i].innerHTML.replace(/^\s+|\s+$/g, "").toLowerCase(),
			B = (this.value + String.fromCharCode(event.keyCode)).toLowerCase();
			if (similar(A, B) > max)
				elems[i].selected = "selected", max = similar(A, B);
		}
	};
</script>

</html>