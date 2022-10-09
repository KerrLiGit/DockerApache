<?php

class Controller_About extends Controller {

	function __construct() {
		$this->model = new Model_Main();
		$this->view = new View();
	}

	function action_index() {
		$data = $this->model->get_auth();
		$this->view->generate('view_about.php', 'view_template.php', $data);
	}
}

?>