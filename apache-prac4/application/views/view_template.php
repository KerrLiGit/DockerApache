<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Сайт Екатерины Анощенковой</title>

    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/navbar.css">

	<link type="image/x-icon" href="/images/back_round.jpg" rel="shortcut icon">
    <link type="image/x-icon" href="/images/back_round.jpg" rel="icon">

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body onload="onResize()">

    <div class="box1o" id="btno" onclick="openNav()"><b>&#9776;</b></div>
    <div class="box1c" id="btnc" onclick="closeNav()"><b>&times;</b></div>

    <menu id="content">
        <div class="box1"><a class="nava" href="/">
                <name style="font-size: 24px;">Екатерина Анощенкова</name><br>учитель&nbsp;математики</a></div>
        <?php
        // Если пользователь является администратором
	if (isset($accessLevel) && $accessLevel == 'admin') {
		echo '<div class="box2" id="box2_2"><a class="nava" href="/admin">Система</a></div>';
	}
		// Если пользователь является администратором или учителем
        if (isset($accessLevel) && ($accessLevel == 'admin' || $accessLevel == 'teacher')) {
			echo '<div class="box2" id="box2_2"><a class="nava" href="/office">Кабинет</a></div>';
		}
        ?>
        <div class="box2" id="box2_3"><a class="nava" href="/learn">Обучение</a></div>
        <div class="box2" id="box2_4"><a class="nava" href="/olymp">Олимпиады</a></div>
        <div class="box2" id="box2_5"><a class="nava" href="/about">Обо мне</a></div>
		<?php

        // Если пользователь авторизован
        if (isset($accessLevel) && $accessLevel != '') {
			echo '<div class="box2" id="box2_6"><a class="nava" href="/auth/signout">Выйти</a></div>';
		}
		else {
			echo '<div class="box2" id="box2_6"><a class="nava" href="/auth/signin">Войти</a></div>';
		}
		?>
    </menu>

    <?php include 'application/views/' . $content_view; ?>

    <script src="/js/navbar.js"></script>

</body>

</html>