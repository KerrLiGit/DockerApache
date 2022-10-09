<?php

class Controller_Auth extends Controller {

	function __construct() {
		$this->model = new Model_Auth();
		$this->view = new View();
	}

	function action_signin() {
		$data = $this->model->signin();
		$this->view->generate('view_signin.php', 'view_template_auth.php', $data);
	}

	function action_signout() {
		$this->model->signout();
		$this->view->generate('view_signout.php', 'view_template_null.php');
	}

	function action_login() {
		$data = $this->model->login();
		$this->view->generate('view_login.php', 'view_template_auth.php', $data);
	}

}

?>