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
	
	public function mapperAction() {
		$data['name'] = ' Don Myers ';
		$data['age'] = ' 23 ';
		$data['id'] = 123;
		$data['tf'] = 1;

		$output = array();

		$map = array('dbname>name>>trim|strtolower','age>>>trim|integer|filter_int[4]','tf>>>filter_int[1]','empty>>e');

		echo '<pre>';

		//  map($filter,&$output,&$input=null,$xss = true)
		$x = $this->input->map($map,$output,$data);
		
		var_dump($output);
		
		var_dump($x);
	}
	
	public function filterAction() {
		$data = ' Don Myers ';
		$filter = 'trim|strtolower|base64_encode';
		
		$isgood = $output = $this->input->filter($data,$filter);
		
		echo '<pre>';
		var_dump($isgood);
		var_dump($data);
		
		
	}
	
}
