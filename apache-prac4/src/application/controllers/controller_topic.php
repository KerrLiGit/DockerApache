<?php

class Controller_Topic extends Controller {

	function __construct() {
		$this->model = new Model_Topic();
		$this->view = new View();
	}

	function action_index() {
		$data = $this->model->get_data();
		$this->view->generate('view_topic.php', 'view_template.php', $data);
	}

}

?>