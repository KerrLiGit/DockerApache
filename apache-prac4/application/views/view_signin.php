<link rel="stylesheet" type="text/css" href="/css/signin.css">

<div class="app-router-container">
    <div class="auth-form">
        <form action="" method="post">
            <p class="form-name">Вход</p>
            <input type="hidden" name="query" value="signin" required>
            <label>Логин</label>
            <label>
                <input type="text" name="login" placeholder="Введите логин" required>
            </label>
            <label>Пароль</label>
            <label>
                <input type="password" name="pass" placeholder="Введите пароль" required>
            </label>
            <label><a href="/auth/login">Регистрация</a></label>
            <button type="submit" title="Вход в систему" name="btn">Войти</button>
            <label class="message">
                <?php
				if ($access == 'denied') {
				    echo 'Неверный пароль';
                }
				else if ($access == 'granted') {
					echo 'Успешный вход';
				}
				?>
            </label>
        </form>
    </div>
</div>