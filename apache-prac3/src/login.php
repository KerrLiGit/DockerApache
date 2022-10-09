<?php
require "vendor/lib.php";
safe_session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Сайт Екатерины Анощенковой</title>
	<link rel="stylesheet" href="css\style.css"> 
        <link rel="stylesheet" href="css\signin.css">
	<script src="js\navbar.js"></script>
	<link type="image/x-icon" href="img\back_round.jpg" rel="shortcut icon">
    	<link type="Image/x-icon" href="img\back_round.jpg" rel="icon">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>                             
<div class="app-router-container">
	<div class="auth-form">
		<form action="vendor/login.php" method="post">
			<p class="form-name">Регистрация</p>
			<label>Фамилия</label>
			<label>
				<input type="text" name="surname" placeholder="Введите фамилию" required>
			</label>
			<label>Имя</label>
			<label>
				<input type="text" name="name" placeholder="Введите имя" required>
			</label>
			<label>Отчество</label>
			<label>
				<input type="text" name="secname" placeholder="Введите отчество" required>
			</label>
			<label>Класс</label>
			<label>
				<select name="class" required>
				<option></option>
				<?php
				$mysqli = get_sql_connection();
				$result = $mysqli->query("SELECT * FROM class");
				foreach ($result as $res) {
					echo '<option value=' . $res['classid'] . '>' . $res['classnum'] . $res['classlit'] . '</option>';				
				}
				?>
				</select>
			</label>
			<label>Логин</label>
			<label>
				<input type="text" name="login" placeholder="Введите логин" required>
			</label>
			<label>Пароль</label>
			<label>
				<input type="password" name="pass" placeholder="Введите пароль" required>
			</label>
			<label><a href="signin.php">Вход</a></label>                                                                             
			<button type="submit" title="Отправить запрос на регистрацию">Отправить</button>
			<label class="message"><?php echo session_message("message-auth"); ?></label>
		</form>
	</div>
</div>
</body>
</html>