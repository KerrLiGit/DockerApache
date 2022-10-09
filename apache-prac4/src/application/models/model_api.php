<?php

class Model_Api extends Model {

	private function auth() {
		if (array_key_exists('HTTP_APIKEY', $_SERVER)) {
			if ($_SERVER['HTTP_APIKEY'] == 'APIKEY')
				return true;
		}
		return false;
	}

	/**
	 * @throws exception
	 */
	public function get_data() {
		$data = array(
			'response' => ''
		);
		$response = array(
			'message' => '404: The requested URL was not found.'
		);
		$data['response'] = json_encode($response, JSON_PRETTY_PRINT);
		return $data;
	}

	/**
	 * @throws exception
	 */
	private function get_all_account() {
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->query('SELECT * FROM account');
		$result = array();
		while ($account = $stmt->fetch_assoc()) {
			$result[] = $account;
		}
		return $result;
	}

	/**
	 * @throws exception
	 */
	private function insert_account($request) {
		$role = $request['role'];
		$login = $request['login'];
		$pass = $request['pass'];
		$surname = $request['surname'];
		$name = $request['name'];
		$secname = $request['surname'];
		$classnum = $request['classnum'];
		$classlit = $request['classlit'];
		$confirm = $request['confirm'];

		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('INSERT INTO account ' .
			'(role, login, `password`, surname, name, secname, classnum, classlit, confirm) ' .
			'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$stmt->bind_param("ssssssisi",
			$role, $login, $pass, $surname, $name, $secname, $classnum, $classlit, $confirm);
		if (!$stmt->execute())
			throw new Exception();
		return $request;
	}

	/**
	 * @throws exception
	 */
	private function get_account($params) {
		$login = $params[0];
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('SELECT * FROM account WHERE login = ?');
		$stmt->bind_param('s', $login);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}

	/**
	 * @throws exception
	 */
	private function update_account($request, $params) {
		$login = $params[0];
		$role = $request['role'];
		$pass = $request['pass'];
		$surname = $request['surname'];
		$name = $request['name'];
		$secname = $request['surname'];
		$classnum = $request['classnum'];
		$classlit = $request['classlit'];
		$confirm = $request['confirm'];

		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('UPDATE account SET ' .
			'role = ?, login = ?, `password` = ?, surname = ?, name = ?, secname = ?, ' .
			'classnum = ?, classlit = ?, confirm = ? WHERE login = ?');
		$stmt->bind_param("ssssssisis",
			$role, $login, $pass, $surname, $name, $secname, $classnum, $classlit, $confirm, $login);
		if (!$stmt->execute())
			return null;
		return $request;
	}

	/**
	 * @throws exception
	 */
	private function delete_account($params) {
		$login = $params[0];
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('DELETE FROM account WHERE login = ?');
		$stmt->bind_param("s", $login);
		$stmt->execute();
	}

	public function account($params) {
		$data = array(
			'response' => ''
		);
		$response = array();
		$request_method = strtolower($_SERVER["REQUEST_METHOD"]);
		$request = (array) json_decode(file_get_contents('php://input'));
		if (!$this->auth()) {
			$response['message'] = '401: Wrong API Key. You must be authorized to view this page.';
			$data['response'] = json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			return $data;
		}
		try {
			// GET /api/account
			if ($request_method == 'get' && empty($params)) {
				$response = $this->get_all_account();
			} // POST /api/account
			else if ($request_method == 'post' && empty($params)) {
				$response = $this->insert_account($request);
			} // GET /api/account/:login
			else if ($request_method == 'get' && !empty($params)) {
				$response = $this->get_account($params);

			} // PUT /api/account/:login
			else if ($request_method == 'put' && !empty($params)) {
				$response = $this->update_account($request, $params);
			} // DELETE /api/account/:login
			else if ($request_method == 'delete' && !empty($params)) {
				$this->delete_account($params);
				$response['message'] = 'Account deleted';
			} else {
				$response['message'] = '501: The requested method is not implemented.';
			}
		}
		catch (Exception $exception) {
			$response['message'] = '500: The server encountered an error processing your request.';
		}
		$data['response'] = json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		return $data;
	}

	/**
	 * @throws exception
	 */
	private function get_all_topic() {
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->query('SELECT * FROM topic');
		$result = array();
		while ($account = $stmt->fetch_assoc()) {
			$result[] = $account;
		}
		return $result;
	}

	/**
	 * @throws exception
	 */
	private function insert_topic($request) {
		$classnum = $request['classnum'];
		$type = $request['type'];
		$topicnum = $request['topicnum'];
		$title = $request['title'];
		$subtitle = $request['subtitle'];
		$content = $request['content'];
		$hidden = $request['hidden'];

		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('INSERT INTO topic ' .
			'(classnum, `type`, topicnum, title, subtitle, content, hidden) ' .
			'VALUES (?, ?, ?, ?, ?, ?, ?)');
		$stmt->bind_param("isissss",
			$classnum, $type, $topicnum, $title, $subtitle, $content, $hidden);
		if (!$stmt->execute())
			throw new Exception();
		return $request;
	}

	/**
	 * @throws exception
	 */
	private function get_topic($params) {
		$classnum = $params[0];
		$type = $params[1];
		$topicnum = $params[2];

		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('SELECT * FROM topic WHERE classnum = ? AND `type` = ? AND topicnum = ?');
		$stmt->bind_param('isi', $classnum, $type, $topicnum);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}

	/**
	 * @throws exception
	 */
	private function update_topic($request, $params) {
		$classnum = $params[0];
		$type = $params[1];
		$topicnum = $params[2];
		$title = $request['title'];
		$subtitle = $request['subtitle'];
		$content = $request['content'];
		$hidden = $request['hidden'];

		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('UPDATE topic SET ' .
			'title = ?, subtitle = ?, `content` = ?, hidden = ? WHERE classnum = ? AND `type` = ? AND topicnum = ?');
		$stmt->bind_param("ssssisi",
			$title, $subtitle, $content, $hidden, $classnum, $type, $topicnum);
		if (!$stmt->execute())
			return null;
		return $request;
	}

	/**
	 * @throws exception
	 */
	private function delete_topic($params) {
		$classnum = $params[0];
		$type = $params[1];
		$topicnum = $params[2];

		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('DELETE FROM topic WHERE classnum = ? AND `type` = ? AND topicnum = ?');
		$stmt->bind_param("isi", $classnum, $type, $topicnum);
		$stmt->execute();
	}

	public function topic($params) {
		$data = array(
			'response' => ''
		);
		$response = array();
		$request_method = strtolower($_SERVER["REQUEST_METHOD"]);
		$request = (array) json_decode(file_get_contents('php://input'));
		if (!$this->auth()) {
			$response['message'] = '401: Wrong API Key. You must be authorized to view this page.';
			$data['response'] = json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
			return $data;
		}
		try {
			// GET /api/topic
			if ($request_method == 'get' && empty($params)) {
				$response = $this->get_all_topic();
			} // POST /api/topic
			else if ($request_method == 'post' && empty($params)) {
				try {
					$response = $this->insert_topic($request);
				} catch (Exception $exception) {
					$response['message'] = '500: The server encountered an error processing your request.';
				}
			} // GET /api/topic/:classnum/:type/:topicnum
			else if ($request_method == 'get' && !empty($params)) {
				$response = $this->get_topic($params);
				if ($response == null) {
					$response['message'] = '500: The server encountered an error processing your request.';
				}
			} // PUT /api/topic/:classnum/:type/:topicnum
			else if ($request_method == 'put' && !empty($params)) {
				$response = $this->update_topic($request, $params);
				if ($response == null) {
					$response['message'] = '500: The server encountered an error processing your request.';
				}
			} // DELETE /api/topic/:login
			else if ($request_method == 'delete' && !empty($params)) {
				$this->delete_topic($params);
				$response['message'] = 'Account deleted';
			} else {
				$response['message'] = '501: The requested method is not implemented.';
			}
		}
		catch (Exception $exception) {
			$response['message'] = '500: The server encountered an error processing your request.';
		}
		$data['response'] = json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		return $data;
	}

}

?>
