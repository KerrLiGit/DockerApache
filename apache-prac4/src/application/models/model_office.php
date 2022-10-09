<?php

class Model_Office extends Model {

	private function get_accessLevel() {
		Session::safe_session_start();
		if (array_key_exists('user', $_SESSION)) {
			return $_SESSION['user']['role'];
		}
		return '';
	}

	private function get_unconfirmed() {
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->query('SELECT count(*) cnt FROM account a, class c WHERE ' .
			'a.confirm = 0 AND a.classnum = c.classnum AND a.classlit = c.classlit');
		$student = $stmt->fetch_assoc();
		$data = array();
		if ($student['cnt'] != 0) {
			$stmt = $mysqli->query('SELECT surname, name, secname, classnum, classlit, login FROM account ' .
				'WHERE confirm = 0 and role = "student" ' .
				'ORDER BY classnum, classlit, surname, name, secname');
			while ($unconfirmed = $stmt->fetch_assoc()) {
				$data[] = $unconfirmed;
			}
		}
		return $data;
	}

	private function get_classes() {
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->query('SELECT classid, classnum, classlit FROM class ORDER BY classnum, classlit');
		$data = array();
		while ($class = $stmt->fetch_assoc()) {
			$data[] = $class;
		}
		return $data;
	}

	private function get_class($classid) {
		$data = array(
			'currentClass' => null,
			'currentStudent' => array()
		);
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('SELECT surname, name, secname, classnum, classlit FROM account ' .
			'LEFT JOIN class USING(classnum, classlit) ' .
			'WHERE confirm = 1 and role = "student" AND classid = ? ORDER BY surname, name, secname');
		$stmt->bind_param('i', $classid);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($student = $result->fetch_assoc()) {
			if (!isset($data['currentClass']))
				$data['currentClass'] = array(
					'classnum' => $student['classnum'],
					'classlit' => $student['classlit']
				);
			$data['currentStudent'][] = array(
				'surname' => $student['surname'],
				'name' => $student['name'],
				'secname' => $student['secname']
			);
		}
		return $data;
	}

	private function confirm($login) {
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('UPDATE account SET confirm = 1 WHERE login = ?');
		$stmt->bind_param('s', $login);
		$stmt->execute();
	}

	private function reject($login) {
		$mysqli = Session::get_sql_connection();
		$stmt = $mysqli->prepare('DELETE FROM account WHERE login = ?');
		$stmt->bind_param('s', $login);
		$stmt->execute();
	}

	private function get_types() {
		$mysqli = Session::get_sql_connection();
		$result = $mysqli->query('SELECT `type`, descript FROM type ORDER BY `type`');
		$data = array();
		while ($type = $result->fetch_assoc()) {
			$data[] = $type;
		}
		return $data;
	}

	private function create_topic() {
		$classnum = $_POST['classnum'];
		$topicnum = $_POST['topicnum'];
		$type = $_POST['type'];
		$title = $_POST['title'];
		$subtitle = $_POST['subtitle'];
		$content = $_POST['content'];
		$hidden = $_POST['hidden'];

		$data['message'] = '';

		if ($type != "olymp" && $classnum < 5) {
			$data['message'] = 'Данная задача не будет отображаться на сайте';
			return;
		}

		$mysqli = Session::get_sql_connection();

		$stmt = $mysqli->prepare('SELECT count(*) FROM topic ' .
			'WHERE classnum = ? AND topicnum = ? AND type = ?');
		$stmt->bind_param('iis', $classnum, $topicnum, $type);
		$stmt->execute();
		if ($stmt->get_result()->fetch_row()[0] == 0) {
			$stmt = $mysqli->prepare('INSERT INTO topic ' .
				'(classnum, topicnum, type, title, subtitle, content, hidden) ' .
				'VALUES (?, ?, ?, ?, ?, ?, ?)');
			$stmt->bind_param('iisssss',
				$classnum, $topicnum, $type, $title, $subtitle, $content, $hidden);
			$stmt->execute();
		}
		else {
			$stmt = $mysqli->prepare('UPDATE topic SET title = ?, subtitle = ?, content = ?, hidden = ? ' .
				'WHERE classnum = ? AND topicnum = ? AND type = ?');
			$stmt->bind_param('ssssiis',
				$title, $subtitle, $content, $hidden, $classnum, $topicnum, $type);
			$stmt->execute();
		}
		return $data;
	}

	private function delete_topic() {
		$classnum = $_POST['classnum'];
		$topicnum = $_POST['topicnum'];
		$type = $_POST['type'];

		$mysqli = Session::get_sql_connection();

		$stmt = $mysqli->prepare('DELETE FROM topic WHERE classnum = ? AND topicnum = ? AND `type` = ?');
		$stmt->bind_param('iis', $classnum, $topicnum, $type);
		$stmt->execute();
	}

	/**
	 * @throws exception
	 */
	public function get_data() {
		$data = array(
			'accessLevel' => '',
			'unconfirmed' => array(),
			'class' => array(),
			'currentClass' => null,
			'currentStudent' => array(),
			'type' => array(),
			'message' => '',
			'topic' => array(
				'classnum' => '',
				'topicnum' => '',
				'type' => '',
				'title' => '',
				'subtitle' => '',
				'content' => '',
				'hidden' => ''
			)
		);

		$data['accessLevel'] = $this->get_accessLevel();

		$data['unconfirmed'] = $this->get_unconfirmed();

		$data['class'] = $this->get_classes();

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'getclassid') {
			$class = $this->get_class($_POST['class']);
			$data['currentClass'] = $class['currentClass'];
			$data['currentStudent'] = $class['currentStudent'];
		}

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'confirm') {
			$this->confirm($_POST['login']);
			header('Location: /office');
		}

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'reject') {
			$this->reject($_POST['login']);
			header('Location: /office');
		}

		$data['type'] = $this->get_types();

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'edit') {
			$data['topic'] = $_POST;
		}

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'delete') {
			$this->delete_topic();
			header('Location: ' . $_POST['url']);
		}

		if (array_key_exists('query', $_POST) && $_POST['query'] == 'createtopic') {
			$this->create_topic();
		}

		return $data;
	}

}

?>