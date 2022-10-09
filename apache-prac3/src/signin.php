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
		<form action="vendor/signin.php" method="post">
			<p class="form-name">Вход</p>
			<label>Логин</label>
			<label>
				<input type="text" name="login" placeholder="Введите логин" required>
			</label>
			<label>Пароль</label>
			<label>
				<input type="password" name="pass" placeholder="Введите пароль" required>
			</label>
			<label><a href="login.php">Регистрация</a></label>
			<button type="submit" title="Вход в систему">Войти</button>
			<label class="message">
				<?php
				echo session_message("message-auth"); 
				?>
			</label>
		</form>
	</div>
</div>
</body>
</html>