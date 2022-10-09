<?php

class Controller_Learn extends Controller {

	function __construct() {
		$this->model = new Model_Main();
		$this->view = new View();
	}

	function action_index() {
		$data = $this->model->get_auth();
		$this->view->generate('view_learn.php', 'view_template.php', $data);
	}
}

?>