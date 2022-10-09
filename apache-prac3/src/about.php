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
	<link rel="stylesheet" href="css\navbar.css">
        <link rel="stylesheet" href="css\anchor.css">
	<link rel="stylesheet" href="css\gallery.css">
	<link href="lightbox/css/lightbox.min.css" rel="stylesheet">
	<script src="js\navbar.js"></script>
	<link type="image/x-icon" href="img\back_round.jpg" rel="shortcut icon">
    	<link type="Image/x-icon" href="img\back_round.jpg" rel="icon">
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
			<div><a id="panel" href="#education" style="font-size: 18px; margin-bottom: 100px;">Образование</a></div>
			<div><a id="panel" href="#work_experience" style="font-size: 18px; margin-bottom: 100px;">Опыт работы</a></div>
			<div><a id="panel" href="#qualification" style="font-size: 18px; margin-bottom: 100px;">Повышение квалификации</a></div>
			<div><a id="panel" href="#public_lesson" style="font-size: 18px; margin-bottom: 100px;">Мастер классы<br>Открытые уроки<br>Выступления</a></div>
			<div><a id="panel" href="#diploms" style="font-size: 18px; margin-bottom: 100px;">Благодарности и грамоты</a></div>
		</div></nav>
		<div class="anchor_main">
			<a class="anchor" id="education"></a>
			<article>Образование</article>
			<div style="padding-bottom: 10px;">
				· 1997 – 2002 гг. МГУ имени Н.П.Огарева. Квалификация по диплому: Математик. Преподаватель математики. Специальность "Математика".
			</div>
			<a class="anchor" id="work_experience"></a>
			<article>Опыт работы</article>
			<div style="padding-bottom: 10px;">
				· 2002 – 2017 гг. МГУ имени Н.П.Огарева факультет математики и информационных технологий, преподаватель кафедры ИВТ.
			</div>
			<div style="padding-bottom: 10px;">
				· 2017 – наст. время МОУ Лицей №26 учитель математики.
			</div>
			<a class="anchor" id="qualification"></a>
			<article>Повышение квалификации</article>
			<div style="padding-bottom: 10px;">
				· Программа "Организация работы классного руководителя в образовательной организации", в объеме 250 ч., 
				ООО «Центр инновационного образования и воспитания», 2021 г.
			</div>
			<div style="padding-bottom: 10px;">
				· Программа «Формирование индивидуального образовательного маршрута педагога в условиях непрерывного 
				повышения профессионального мастерства», в объеме 108 ч., ГБУДПО  Республики Мордовия «Центр непрерывного 
				повышения профессионального мастерства педагогических работников – «Педагог 13.ру» 2019 г.
			</div>
			<div style="padding-bottom: 10px;">
				· Программа «Кибербезопасность в школе», в объеме 36 ч., ГБУДПО  Республики Мордовия «Центр непрерывного 
				повышения профессионального мастерства педагогических работников – «Педагог 13.ру» 2019 г.
			</div>
			<div style="padding-bottom: 10px;">
				· Программа «Технологии формирования универсальных учебных действий учащихся в обучении математике», в 
				объеме 72 ч., ФГБОУВО «Мордовский государственный педагогический институт им. М.Е.Евсевьева»., 2019 г.
			</div>
			<a class="anchor" id="public_lesson"></a>
			<article>Мастер-классы, открытые уроки и выступления</article>
			<div style="padding-bottom: 10px;">
				· 2019 г. – Открытое внеклассное занятие по алгебре с обучающимися 8-9 классов «Процент. От простого к 
				сложному» на Республиканском методическом семинаре «Повышение качества математического образования». 
				Республика Мордовия, г.Саранск.
			</div>
			<div style="padding-bottom: 10px;">
				· 2021 г. – Выступление на тему «Организация образовательной среды для подготовки обучающихся по 
				математике на основе образовательного портала «Сдам ГИА / Решу ЕГЭ» в рамках Республиканского 
				методического семинара «Технологии подготовки обучающихся к ВПР, ОГЭ и ЕГЭ по математике СС 
				использованием электронных образовательных ресурсов». г. Саранск.
			</div>
			<a class="anchor" id="diploms"></a>
			<article>Благодарности и грамоты</article>
			<div class="container">
				<div id="gallery">
					<figure class="photo">
						<a href="img/diploms/2017_1.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2017_1.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2018_1.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2018_1.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2019_1.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2019_1.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2019_2.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2019_2.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2019_3.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2019_3.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2019_4.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2019_4.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2019_5.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2019_5.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2019_6.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2019_6.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2020_1.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2020_1.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2020_2.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2020_2.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2020_3.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2020_3.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2021_1.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2021_1.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2021_2.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2021_2.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2021_3.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2021_3.jpg"/>
						</a>
					</figure>
					<figure class="photo">
						<a href="img/diploms/2021_4.jpg" data-lightbox="roadtrip">
							<img src="img/diploms/min/2021_4.jpg"/>
						</a>
					</figure>
				</div>
			</div>
			<script src="lightbox/js/lightbox-plus-jquery.min.js"></script>  
		</div>
	</div>
</div>


</body>

</html>