<?php
require "vendor/lib.php";
safe_session_start();
if (!teacher_access()) {
	header('Location: /index.php');
	$_SESSION['message'] = 'Отказано в доступе: несоответствие уровня доступа.';
} 
?>

<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Сайт Екатерины Анощенковой</title>
	<link rel="stylesheet" href="css\style.css">
	<link rel="stylesheet" href="css\navbar.css">
        <link rel="stylesheet" href="css\anchor.css">       
	<link rel="stylesheet" href="css\cboard.css">
	<!--<link rel="stylesheet" href="css\modal.css">-->
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
			$mysqli = get_sql_connection();
			$stmt = $mysqli->query("SELECT a.login FROM account a, class c WHERE
				a.confirm = false AND a.classnum = c.classnum AND a.classlit = c.classlit");
			$student = $stmt->fetch_row();
			if (isset($student)) {
				echo '<div><a id="panel" href="#confirm" style="font-size: 18px; margin-bottom: 10px;">Подтверждение регистрации</a></div>';
			}
			?>
			<div><a id="panel" href="#outclass" style="font-size: 18px; padding-bottom: 10px;">Список классов</a></div>
			<div><a id="panel" href="#create" style="font-size: 18px; padding-bottom: 10px;">Создание урока</a></div>
			<!--<div><a id="panel" href="#another" style="font-size: 18px; padding-bottom: 10px;">Пусто</a></div>-->
		</div></nav>
		<div class="anchor_main">
			<?php
			$mysqli = get_sql_connection();
			$stmt = $mysqli->query('SELECT surname, name, secname, classnum, classlit, login FROM account 
				WHERE confirm = 0 and role = "student"
				ORDER BY classnum, classlit, surname, name, secname');
			$student = $stmt->fetch_row();
			if (isset($student)) {
				echo '<a class="anchor" id="confirm"></a>';
				echo '<article>Подтверждение регистрации</article>';
				echo '<a class="anchor" id="confirm"></a>';
				echo '<table class="cboard">';
				$flag = 0;
				while (isset($student)) {
					echo '<tr>';
					$flag++;
					echo '<td>' . $student[0] . ' ' . $student[1] . ' ' . $student[2] . '</td>';
					echo '<td>' . $student[3] . $student[4] . ' класс</td>';
					echo '<td><form action="vendor/confirm.php" method="post">
						<input type="hidden" name="login" value=' . $student[5] . ' required></input>
						<button type="submit" title="Подтвердить">&check;</button></form></td>';
					echo '<td><form action="vendor/reject.php" method="post">
						<input type="hidden" name="login" value=' . $student[5] . ' required></input>
						<button type="submit" title="Отклонить">&cross;</button></form></td>';
					echo '</tr>';
					$student = $stmt->fetch_row();
				}
				echo '</table>';
			}
			?>
			<a class="anchor" id="outclass"></a>
				<article>Список классов</article>
				<div style="padding-bottom: 10px;">
					<form action="vendor/getclassid.php" method="post">
						<label>Класс</label>
						<label>
							<select name="class" required>
								<option></option>
								<?php
								$mysqli = get_sql_connection();
								$result = $mysqli->query("SELECT classid, classnum, classlit FROM class 
									ORDER BY classnum, classlit");
								foreach ($result as $res) {
									echo '<option value=' . $res['classid'] . '>' . 
											$res['classnum'] . $res['classlit'] . '</option>';				
								}
								?>
							</select>
						</label>
						<button type="submit" title="Вывести список класса">Вывести</button>
						<label class="message"><?php echo session_message("message-outclass"); ?></label>
					</form>
				</div>
				<div style="padding-bottom: 10px;">
					<?php 
					if ($_GET) {                          
						$classid = $_GET['classid'];
						$mysqli = get_sql_connection();
						$stmt = $mysqli->prepare('SELECT surname, name, secname, classnum, classlit FROM account
							LEFT JOIN class USING(classnum, classlit) 
							WHERE confirm = 1 and role = "student" AND classid = ? ORDER BY surname, name, secname');
						$stmt->bind_param('i', $classid);
						if ($stmt->execute()) {
							$result = $stmt->get_result();
							$student = $result->fetch_row();
							if ($student)
								echo $student[3] . $student[4] . ' класс';
							$flag = 0;
							echo '<table class="cboard">';
							while ($student) {
								echo '<tr>';  
								$flag++;
								echo '<td>' . $student[0] . ' ' . $student[1] . ' ' . $student[2] . '</td>';
								echo '</tr>';
								$student = $result->fetch_row();
							}				
							echo '</table>';
						}
						else {
							echo 'Техническая ошибка: ' . $mysqli->error;
						}
					}
					?>
				</div>
			<a class="anchor" id="create"></a>
				<article>Создание урока</article>
				<div style="padding-bottom: 10px;">
					Для вставки ссылки используется тег 
					<input value='<a href="https://google.com">GOOGLE</a>' size=36 readonly></input>,
					где https://google.com - сама ссылка, а GOOGLE - кликабельный текст, 
					который будет отображаться вместо ссылки.
				</div>
				<div style="padding-bottom: 10px;">
					Каждый абзац вставляется внутрь тега  
					<input value='<div style="padding-bottom: 10px;">Абзац</div>' size=41 readonly></input>.
					Перевод строки с помощью клавиши Enter не сработает.
				</div>
				<div style="padding-bottom: 10px;">
					&nbsp;&nbsp;<span class="checkmark">&check;</span>&nbsp;
					Важный абзац можно оформить с галочкой. Для этого внутри тега абзаца, но перед его содержанием
					вставляется строка
					<input type="code" value='&amp;nbsp;&amp;nbsp;<span class="checkmark">&amp;check;</span>&amp;nbsp;' size=55 readonly></input>.
				</div>
				<div style="padding-bottom: 10px;">
					Если указать в полях Класс, Номер и Тип урока уже существующий урок, то он будет отредактирован.
				</div>
				<div style="padding-bottom: 10px;">
                                        <form action="vendor/createtopic.php" method="post">
						<table>
							<tr>
								<td>Класс</td>
								<td><input pattern="^(1|2|3|4|5|6|7|8|9|10|11)$" name="class" required
									placeholder="Число от 1 до 11" autocomplete="off"></td>
							</tr>
							<tr>
								<td>Номер урока</td>
								<td><input type="number" name="num" required
									autocomplete="off"></td> <!--ЗАПРЕТИТЬ ВВОД ОТРИЦАТЕЛЬНОГО ЧИСЛА-->
							</tr>
							<tr>
								<td>Предмет</td>
								<td>
								<select name="type" required cols=100>
									<?php
									$mysql = get_sql_connection();
									$types = $mysql->query('SELECT `type`, descript FROM type ORDER BY `type`');
									$type = $types->fetch_row();
									echo '<option></option>';
									while ($type) {
										echo '<option value="' . $type[0] . '">' . $type[1] . '</option>';
										$type = $types->fetch_row();
									}
									?>								
								</select>
								</td>
							</tr>
							<tr>
								<td>Заголовок</td>
								<td><input type="text" name="title" required class="input" 
									maxlength="80" autocomplete="off"></td>
							</tr>
						        <tr>
								<td>Подзаголовок</td>
								<td><input type="text" name="subtitle" required class="input" 
									maxlength="20" autocomplete="off"></td>
							</tr>
						</table>
						<label>Содержание урока</label><br>
  						<textarea name="content" class="longinput" maxlength="1000"></textarea><br>
						<label>Скрытое содержание урока</label><br>
  						<textarea name="hidden" class="longinput" maxlength="1000"></textarea><br>
						<button type="submit" title="Сохранить урок">Сохранить</button>
 					</form>
				</div>
				<div style="padding-bottom: 10px;">	
				</div>	
				<div style="padding-bottom: 10px;">
					
				</div>
			<!--<a class="anchor" id="another"></a>
				<article>Пустой блок</article>
				<div style="padding-bottom: 10px;">
					Текст...
				</div>-->
		</div>
		<!--<div class="anchor_button"></div>-->
	</div>
	<!--<a href="#openModal">Открыть модальное окно</a>
	<div id="openModal" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Название</h3>
					<a href="#close" title="Close" id="close" color='floralwhite'>&times;</a>
				</div>
				<div class="modal-body">    
					<p>Содержимое модального окна...</p>
				</div>
			</div>
		</div>
	</div>-->
</div>

<!--<script>
	document.addEventListener("DOMContentLoaded", function () {
		var scrollbar = document.body.clientWidth - window.innerWidth + 'px';
		console.log(scrollbar);
		document.querySelector('[href="#openModal"]').addEventListener('click', function () {
			document.body.style.overflow = 'hidden';
			document.querySelector('#openModal').style.marginLeft = scrollbar;
		});
		document.querySelector('[href="#close"]').addEventListener('click', function () {
			document.body.style.overflow = 'visible';
			document.querySelector('#openModal').style.marginLeft = '0px';
		});
	});
</script>-->

</body>

</html>