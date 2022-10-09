<link rel="stylesheet" href="/css/anchor.css">
<link rel="stylesheet" href="/css/cboard.css">

<div id="unic_content">
	<div class="anchor_wrapper">
		<nav><div class="anchor_menu" id="anchor_content">
				<?php
				if (count($unconfirmed) != 0) {
					echo '<div><a id="panel" href="#confirm" style="font-size: 18px; margin-bottom: 10px;">' .
                        'Подтверждение регистрации</a></div>';
				}
				?>
				<div><a id="panel" href="#outclass" style="font-size: 18px; padding-bottom: 10px;">Список классов</a></div>
				<div><a id="panel" href="#create" style="font-size: 18px; padding-bottom: 10px;">Создание урока</a></div>
				<!--<div><a id="panel" href="#another" style="font-size: 18px; padding-bottom: 10px;">Пусто</a></div>-->
			</div></nav>
		<div class="anchor_main">
			<?php
			if (count($unconfirmed) != 0) {
				echo '<a class="anchor" id="confirm"></a>';
				echo '<article>Подтверждение регистрации</article>';
				echo '<div style="padding-bottom: 10px;">';
				echo '<a class="anchor" id="confirm"></a>';
				echo '<table class="cboard">';
				foreach ($unconfirmed as $student) {
					echo '<tr>';
					echo '<td>' . $student['surname'] . ' ' . $student['name'] . ' ' . $student['secname'] . '</td>';
					echo '<td>' . $student['classnum'] . $student['classlit'] . ' класс</td>';
					echo '<td><form action="" method="post">
						<input type="hidden" name="query" value="confirm" required>
						<input type="hidden" name="login" value=' . $student['login'] . ' required>
						<button type="submit" title="Подтвердить">&check;</button></form></td>';
					echo '<td><form action="" method="post">
                        <input type="hidden" name="query" value="reject" required>
						<input type="hidden" name="login" value=' . $student['login'] . ' required>
						<button type="submit" title="Отклонить">&cross;</button></form></td>';
					echo '</tr>';
				}
				echo '</table>';
				echo '</div>';
			}
			?>
			<a class="anchor" id="outclass"></a>
			<article>Список классов</article>
			<div style="padding-bottom: 10px;">
				<form action="" method="post">
                    <input type="hidden" name="query" value="getclassid" required>
					<label>Класс</label>
					<label>
						<select name="class" required>
							<option></option>
							<?php
							foreach ($class as $c) {
								echo '<option value=' . $c['classid'] . '>' .
                                    $c['classnum'] . $c['classlit'] . '</option>';
							}
							?>
						</select>
					</label>
					<button type="submit" title="Вывести список класса">Вывести</button>
				</form>
			</div>
			<div style="padding-bottom: 10px;">
				<?php
				if ($currentClass) {
					echo $currentClass['classnum'] . $currentClass['classlit'] . ' класс';
					echo '<table class="cboard">';
					foreach ($currentStudent as $student) {
						echo '<tr>';
						echo '<td>' . $student['surname'] . ' ' . $student['name'] . ' ' .
                            $student['secname'] . '</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
				?>
			</div>
			<a class="anchor" id="create"></a>
			<article>Создание урока</article>
			<div style="padding-bottom: 10px;">
				Для вставки ссылки используется тег
				<input value="<a href='https://google.com'>GOOGLE</a>" size=36 readonly>,
				где https://google.com - сама ссылка, а GOOGLE - кликабельный текст,
				который будет отображаться вместо ссылки.
			</div>
			<div style="padding-bottom: 10px;">
				Каждый абзац вставляется внутрь тега
				<input value="<div style='padding-bottom: 10px;'>Абзац</div>" size=41 readonly>.
				Перевод строки с помощью клавиши Enter не сработает.
			</div>
			<div style="padding-bottom: 10px;">
				&nbsp;&nbsp;<span class="checkmark">&check;</span>&nbsp;
				Важный абзац можно оформить с галочкой. Для этого внутри тега абзаца, но перед его содержанием
				вставляется строка
				<input type="code" value="&amp;nbsp;&amp;nbsp;<span class='checkmark'>&amp;check;</span>&amp;nbsp;"
                       size=55 readonly>.
			</div>
			<div style="padding-bottom: 10px;">
				Если указать в полях Класс, Номер и Тип урока уже существующий урок, то он будет отредактирован.
			</div>
			<div style="padding-bottom: 10px;">
				<form action="" method="post">
                    <input type="hidden" name="query" value="createtopic" required>
					<table>
						<tr>
							<td>Класс</td>
							<td><input pattern="^(1|2|3|4|5|6|7|8|9|10|11)$" name="classnum" required
									   placeholder="Число от 1 до 11" autocomplete="off"
                                       value="<?php echo $topic['classnum'] ?>"></td>
						</tr>
						<tr>
							<td>Номер урока</td>
                            <!--ЗАПРЕТИТЬ ВВОД ОТРИЦАТЕЛЬНОГО ЧИСЛА-->
							<td><input type="number" name="topicnum" required
									   autocomplete="off" value="<?php echo $topic['topicnum'] ?>"></td>
						</tr>
						<tr>
							<td>Предмет</td>
							<td>
								<select name="type" required cols=100>
									<?php
									echo '<option></option>';
									foreach ($type as $t) {
									    if ($topic['type'] == $t['type']) {
											echo '<option value="' . $t['type'] . '"
											selected="selected">' . $t['descript'] . '</option>';
										}
									    else {
											echo '<option value="' . $t['type'] . '">' . $t['descript'] . '</option>';
                                        }
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Заголовок</td>
							<td><input type="text" name="title" required class="input"
									   maxlength="80" autocomplete="off" value="<?php echo $topic['title'] ?>"></td>
						</tr>
						<tr>
							<td>Подзаголовок</td>
							<td><input type="text" name="subtitle" required class="input"
									   maxlength="20" autocomplete="off" value="<?php echo $topic['subtitle'] ?>"></td>
						</tr>
					</table>
					<label>Содержание урока</label><br>
					<textarea name="content" class="longinput"
                              maxlength="1000"><?php echo $topic['content'] ?></textarea><br>
					<label>Скрытое содержание урока</label><br>
					<textarea name="hidden" class="longinput"
                              maxlength="1000"><?php echo $topic['hidden'] ?></textarea><br>
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

</div>