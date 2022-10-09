<?php

class Model_Auth extends Model {

	/**
	 * @throws exception
	 */
	public function signin() {
		$data = array(
			'access' => ''
		);

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'signin') {
			$login = $_POST['login'];
			$pass = $_POST['pass'];
			//$pass = md5($_POST['pass']);

			$mysqli = Session::get_sql_connection();
			$stmt = $mysqli->prepare('SELECT * FROM account WHERE login = ? AND `password` = ? AND confirm = 1');
			$stmt->bind_param("ss", $login, $pass);
			$stmt->execute();
			$check = $stmt->get_result();
			if (mysqli_num_rows($check) > 0) {
				$user = $check->fetch_assoc();
				Session::safe_session_start();
				$_SESSION['user'] = [
					'login' => $user['login'],
					'surname' => $user['surname'],
					'name' => $user['name'],
					'secname' => $user['secname'],
					'role' => $user['role'],
					'classnum' => $user['classnum'],
					'classlit' => $user['classlit'],
				];
				$data['access'] = 'granted';
				header('Location: /');
			}
			else {
				$data['access'] = 'denied';
			}
		}
		return $data;
	}

	public function signout() {
		Session::safe_session_start();
		Session::delete_session();
	}

	public function login() {
		$data = array(
			'class' => array(),
			'message' => ''
		);
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->query('SELECT classid, classnum, classlit FROM class ORDER BY classnum, classlit');
		while ($class = $stmt->fetch_assoc()) {
			$data['class'][] = $class;
		}

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'login') {
			$surname = $_POST['surname'];
			$name = $_POST['name'];
			$secname = $_POST['secname'];
			$login = $_POST['login'];
			$pass = $_POST['pass'];
			$role = "student";
			$classid = $_POST['class'];

			$stmt = $mysqli->prepare("SELECT classnum, classlit FROM class WHERE classid = ?");
			$stmt->bind_param("i", $classid);
			$stmt->execute();
			$class = $stmt->get_result()->fetch_assoc();
			if (empty($class)) {
				$data['message'] = "Класс не найден.";
				return $data;
			}
			$classnum = $class['classnum'];
			$classlit = $class['classlit'];
			$stmt = $mysqli->prepare("SELECT COUNT(*) FROM account WHERE login = ?");
			$stmt->bind_param("s", $login);
			$stmt->execute();
			if ($stmt->get_result()->fetch_row()[0] > 0) {
				$data['message'] = "Такой логин уже существует.";
				return $data;
			}

			$stmt = $mysqli->prepare('INSERT INTO account ' .
				'(role, login, `password`, surname, name, secname, classnum, classlit) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
			$stmt->bind_param("ssssssis",
				$role, $login, $pass, $surname, $name, $secname, $classnum, $classlit);
			$stmt->execute();
			$data['message'] = "Успешная регистрация. Ожидайте подтверждения аккаунта учителем." . $mysqli->error;
		}
		return $data;
	}

}

?>