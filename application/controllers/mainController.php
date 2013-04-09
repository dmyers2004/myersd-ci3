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
	
	public function testAction() {
		$data['name'] = ' Don Myers ';
		$data['age'] = ' 23 ';
		$data['id'] = 123;

		$rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|base64_encode',
			),
			array(
				'field' => 'age',
				'label' => 'Age',
				'rules' => 'trim|integer',
			),
			array(
				'field' => 'id',
				'label' => 'Id',
				'rules' => 'integer'
			),
			array(
				'field' => 'empty',
				'label' => 'Empty',
				'rules' => 'alpha',
				'default' => 'e'
			),
			array(
				'field' => 'foo',
				'label' => 'Empty',
				'rules' => 'alpha',
			)
		);
				

		echo '<pre>';
		echo 'Mapper'.chr(10);

		$output = array();

		//  map($filter,&$output,&$input=null,$xss = true)
		$x = $this->validate->map($rules,$output,$data);
		
		var_dump($output);
		
		var_dump($x);

		echo 'filter'.chr(10);

		$data = ' Don Myers ';
		$filter = 'trim|strtolower|base64_encode';
		
		$isgood = $output = $this->validate->filter($data,$filter);
		
		var_dump($isgood);
		var_dump($data);
	}
	
}
