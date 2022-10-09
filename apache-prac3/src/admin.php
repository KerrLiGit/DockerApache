<?php
require "vendor/lib.php";
safe_session_start();
if (!admin_access()) {
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
			<div><a id="panel" href="#log" style="font-size: 18px; padding-bottom: 10px;">Логи</a></div>
		</div></nav>
		<div class="anchor_main">
			<a class="anchor" id="log"></a>
				<article>Список логов</article>
				<div style="padding-bottom: 10px;">
					<form action="vendor/getlogs.php" method="post">
						<table>
							<tr>
							<td><label>Период</label></td>
							<td><label><input type="date" name="datefrom" title="От" required 
								value="<?php echo date("Y-m-d") ?>">&nbsp;-</label>
							<label><input type="date" name="dateto" title="До" required 
								value="<?php echo date("Y-m-d") ?>"></input><br></label></td>
							</tr>
							<tr>
							<td><label>Тип</label></td>
							<td>
							<select name="action" required>
								<option value="all">Все</option>
								<option value="INSERT">INSERT</option>
								<option value="UPDATE">UPDATE</option>
								<option value="DELETE">DELETE</option>
							</select>
							</td>
						</table>
						<button type="submit" title="Вывести список логов">Вывести</button>
						<label class="message"><?php echo session_message("message-outclass"); ?></label>
					</form>
				</div>
				<div style="padding-bottom: 10px;">
					<?php
					if (isset($_SESSION['logs'])) {
						echo '<table class="cboard" style="font-size:0.7em;">';
						echo '<tr>';
						echo '<td style="width:10em"><b>eventdate</b></td>';
						echo '<td><b>login</b></td>';
						echo '<td><b>action</b></td>';
						echo '<td><b>tablename</b></td>';
						echo '<td><b>descript</b></td>';
						echo '</tr>';
						for ($i = 0; $i < count($_SESSION['logs']); $i++) {
							echo '<tr>';
							echo '<td>' . $_SESSION['logs'][$i]['eventdate'] . '</td>';
							echo '<td>' . $_SESSION['logs'][$i]['login'] . '</td>';
							echo '<td>' . $_SESSION['logs'][$i]['action'] . '</td>';
							echo '<td>' . $_SESSION['logs'][$i]['tablename'] . '</td>';
							echo '<td>' . $_SESSION['logs'][$i]['descript'] . '</td>';	
							echo '</tr>';
						}
						echo '</table>';
					}
					unset($_SESSION['logs']); 
					?>
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