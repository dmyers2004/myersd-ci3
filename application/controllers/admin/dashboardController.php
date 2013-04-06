<?php defined('BASEPATH') OR exit('No direct script access allowed');

class dashboardController extends MY_AdminController {

	public function indexAction() {
		$this->load->template('admin/dashboard/index');
	}

	public function upAction() {
		$this->load->library('migration');

		$this->migration->version(2);
	}

}