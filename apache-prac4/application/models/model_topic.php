<?php

class Model_Topic extends Model {

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
	private function get_anchors($classnums, $type) {
		$mysqli = Session::get_sql_connection();
		$data = array();
		for ($i = 0; $i < count($classnums); $i++) {
			$classnum = $classnums[$i];
			$stmt = $mysqli->prepare('SELECT topicnum, subtitle FROM topic WHERE classnum = ? AND type = ?');
			$stmt->bind_param('is', $classnum, $type);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($anchor = $result->fetch_assoc()) {
				$data[] = $anchor;
			}
		}
		return $data;
	}

	/**
	 * @throws exception
	 */
	private function get_topics_links($classnums, $type) {
		$data = array(
			'topic' => array(),
			'link' => array()
		);
		$mysqli = Session::get_sql_connection();
		for ($i = 0; $i < count($classnums); $i++) {
			$classnum = $classnums[$i];
			$stmt = $mysqli->prepare('SELECT classnum, topicnum, type, title, content, hidden FROM topic ' .
				'WHERE classnum = ? AND type = ?');
			$stmt->bind_param('is', $classnum, $type);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($topic = $result->fetch_assoc()) {
				$data['topic'][] = $topic;
			}

			/*$stmt = $mysqli->prepare('SELECT COUNT(*) cnt, deadline FROM link WHERE login = ? AND classnum = ?
						AND topicnum = ? AND type = ? AND NOW() < deadline');
			$student_login = $_SESSION['user']['login'];
			$topic_classnum = $topic['classnum'];
			$topic_topicnum = $topic['topicnum'];
			$topic_type = $topic['type'];
			$stmt->bind_param('siis', $student_login, $topic_classnum, $topic_topicnum, $topic_type);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($link = $result->fetch_assoc()) {
				$data['link'][] = $link;
			}*/
		}
		return $data;
	}

	/**
	 * @throws exception
	 */
	public function get_data() {
		$classnums = $_GET['class'];
		$type = $_GET['type'];

		$data = array(
			'accessLevel' => '',
			'type' => $type,
			'anchor' => array(),
			'topic' => array(),
			'link' => array(),
			'request_uri' => Session::request_uri()
		);

		$data['accessLevel'] = $this->get_accessLevel();

		$data['anchor'] = $this->get_anchors($classnums, $type);

		$topics_links = $this->get_topics_links($classnums, $type);
		$data['topic'] = $topics_links['topic'];
		$data['link'] = $topics_links['link'];

		return $data;
	}

}

?>