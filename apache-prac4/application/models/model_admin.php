<?php

class Model_Admin extends Model {

	private function get_accessLevel() {
		Session::safe_session_start();
		if (array_key_exists('user', $_SESSION)) {
			return $_SESSION['user']['role'];
		}
		return '';
	}

	/**
	 * @throws exception
	 */
	private function get_logs($datefrom, $dateto, $action) {
		$mysqli = Session::get_sql_connection();
		$datefrom .= ' 00:00:00';
		$dateto .= ' 23:59:59';

		Session::safe_session_start();
		if (isset($_SESSION['logs'])) {
			unset($_SESSION['logs']);
		}
		$data = array();

		if ($action == 'all') {
			$stmt = $mysqli->prepare('SELECT * FROM `log` WHERE eventdate >= ? AND eventdate <= ?');
			$stmt->bind_param("ss", $datefrom, $dateto);
		}
		else {
			$stmt = $mysqli->prepare('SELECT * FROM `log` ' .
				'WHERE eventdate >= ? AND eventdate <= ? AND action = ?');
			$stmt->bind_param("sss", $datefrom, $dateto, $action);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$log = $result->fetch_assoc();
		while (!is_null($log)) {
			$data[] = $log;
			$log = $result->fetch_assoc();
		}
		return $data;
	}

	/**
	 * @throws exception
	 */
	public function get_data() {
		$data = array(
			'accessLevel' => '',
			'log' => array()
		);

		$data['accessLevel'] = $this->get_accessLevel();

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'log') {
			$data['log'] = $this->get_logs($_POST['datefrom'], $_POST['dateto'], $_POST['action']);
		}

		return $data;
	}

}

?>