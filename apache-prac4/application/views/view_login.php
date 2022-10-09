<link rel="stylesheet" href="/css/signin.css">

<div class="app-router-container">
	<div class="auth-form">
		<form action="" method="post">
			<p class="form-name">Регистрация</p>
            <input type="hidden" name="query" value="login" required>
			<label>Фамилия</label>
			<label><input type="text" name="surname" placeholder="Введите фамилию" required></label>
			<label>Имя</label>
			<label><input type="text" name="name" placeholder="Введите имя" required></label>
			<label>Отчество</label>
			<label><input type="text" name="secname" placeholder="Введите отчество" required></label>
			<label>Класс</label>
			<label>
				<select name="class" required>
					<option></option>
					<?php
					foreach ($class as $c) {
						echo '<option value=' . $c['classid'] . '>' . $c['classnum'] . $c['classlit'] . '</option>';
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
			<label><a href="/auth/signin">Вход</a></label>
			<button type="submit" title="Отправить запрос на регистрацию">Отправить</button>
			<label class="message"><?php echo $message ?></label>
		</form>
	</div>
</div>