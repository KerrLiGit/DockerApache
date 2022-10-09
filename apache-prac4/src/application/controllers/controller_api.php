<?php

class Controller_Api extends Controller {

	function __construct() {
		$this->model = new Model_Api();
		$this->view = new View();
	}

	function action_index() {
		$data = $this->model->get_data();
		$this->view->generate('view_api.php', 'view_template_null.php', $data);
	}

	function action_account($params) {
		$data = $this->model->account($params);
		$this->view->generate('view_api.php', 'view_template_null.php', $data);
	}

	function action_topic($params) {
		$data = $this->model->topic($params);
		$this->view->generate('view_api.php', 'view_template_null.php', $data);
	}
}

?>