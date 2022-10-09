<link rel="stylesheet" href="/css/anchor.css">

<div id="unic_content">
	<div class="anchor_wrapper">
		<nav><div class="anchor_menu" id="anchor_content">
				<?php
				for ($i = 0; $i < count($anchor); $i++) {
				    echo "<div><a id='panel' href='#lesson" . $anchor[$i]['topicnum'] .
				        "' style='font-size: 18px; margin-bottom: 10px;'>";
				    echo $anchor[$i]['subtitle'] . '</a></div>';
				}
				?>
			</div></nav>
		<div class="anchor_main">
			<?php
			echo '<table border="0px" width="100%">';
			for ($i = 0; $i < count($topic); $i++) {
			    echo '<tr>';
			    echo '<td valign="top">';
			    echo '<a class="anchor" id="lesson' . $topic[$i]['topicnum'] . '"></a>';
			    echo '<article>' . $topic[$i]['title'] . '</article>';
			    echo $topic[$i]['content'];
			    if ($topic[$i]['hidden'] != '' && ($accessLevel == 'teacher' || $accessLevel == 'admin')) {
					if ($accessLevel == '') {
						echo '<div>' .
							'<a href="/auth/signin">Продолжение после получения доступа у учителя</a></div>';
					} else {
						if ($accessLevel == 'teacher' || $accessLevel == 'admin') {
							echo '<div><a href="">Скрытое содержание</a></div>';
							echo $topic[$i]['hidden'];
						} else if ($link[$i]['cnt']) {
							echo '<div><a href="">Продолжение доступно до ' .
								date('d.m.Y', $link[$i]['deadline']) . '</a></div>';
							echo $topic[$i]['hidden'];
						} else {
							echo '<div><a href="">Продолжение не доступно</a></div>';
						}
					}
				}
				echo '</td>';
			    if ($accessLevel == 'teacher' || $accessLevel == 'admin') {
					echo '<td valign="top" width="400px" style="padding-left:20px">';
					echo '<form action="/office#create" method="post">';
					echo '<input type="hidden" name="query" value="edit">';
					echo '<input type="hidden" name="classnum" value="' . $topic[$i]['classnum'] . '">';
					echo '<input type="hidden" name="type" value="' . $topic[$i]['type'] . '">';
					echo '<input type="hidden" name="topicnum" value="' . $topic[$i]['topicnum'] . '">';
					echo '<input type="hidden" name="title" value="' . $topic[$i]['title'] . '">';
					echo '<input type="hidden" name="subtitle" value="' . $anchor[$i]['subtitle'] . '">';
					echo '<input type="hidden" name="content" value="' . $topic[$i]['content'] . '">';
					echo '<input type="hidden" name="hidden" value="' . $topic[$i]['hidden'] . '">';
					echo '<button type="submit">Редактировать</button>';
					echo '</form>';
					echo '<form action="/office" method="post">';
					echo '<input type="hidden" name="query" value="delete">';
					echo '<input type="hidden" name="classnum" value="' . $topic[$i]['classnum'] . '">';
					echo '<input type="hidden" name="type" value="' . $topic[$i]['type'] . '">';
					echo '<input type="hidden" name="topicnum" value="' . $topic[$i]['topicnum'] . '">';
					echo '<input type="hidden" name="url" value="' . $_SERVER["REQUEST_URI"] . '">';
					echo '<button type="submit">Удалить</button>';
					echo '</form>';
					echo '</td>';
                }
				echo '</tr>';
			}
			/*for ($j = 0; $j < count($topic); $j++) {

				echo '</td>';
			    /*if (teacher_access()) {
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
			}*/
			echo '</table>';
		    ?>
		</div>
		<div class="anchor_button"></div>
	</div>
</div>