<?php

class Controller_Office extends Controller {

	function __construct() {
		$this->model = new Model_Office();
		$this->view = new View();
	}

	function action_index() {
		$data = $this->model->get_data();
		$this->view->generate('view_office.php', 'view_template.php', $data);
	}

}

?>