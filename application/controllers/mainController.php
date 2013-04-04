<?php defined('BASEPATH') OR exit('No direct script access allowed');

class mainController extends MY_PublicController {

	public function indexAction() {
		$this->load->template('main/index');
	}

	public function createAdminAction() {
		//var_dump($this->tank_auth->create_user('dmyers', 'admin@admin@.com', 'password', false));
	}
	
	public function viewAction() {
		$this->load->view('tank-auth/login_form');
	}
	
}
