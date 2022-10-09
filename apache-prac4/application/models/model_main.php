<?php

class Model_Main extends Model {

	/**
	 * @throws exception
	 */
	public function get_auth() {
		$data = array(
			'accessLevel' => ''
		);
		Session::safe_session_start();
		if (isset($_SESSION) && array_key_exists('user', $_SESSION)) {
			$data['accessLevel'] = $_SESSION['user']['role'];
		}
		return $data;
	}

}

?>