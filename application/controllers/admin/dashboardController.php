<?php defined('BASEPATH') OR exit('No direct script access allowed');

class dashboardController extends MY_AdminController {

	public $controller_path = '/admin/dashboard/';	

	public function indexAction() {
		$this->load->template($this->controller_path.'index');
	}

	public function upAction() {
		$this->load->library('migration');

		$this->migration->version(2);
	}

}