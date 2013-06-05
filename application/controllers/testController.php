<?php defined('BASEPATH') OR exit('No direct script access allowed');

class mainController extends MY_PublicController
{

	public function createAdminAction()
	{
		//var_dump($this->auth->create_user('dmyers', 'admin@admin@.com', 'password', false));
	}

	public function viewAction()
	{
		$this->page->build('tank-auth/login_form');
	}

	public function testconfigAction()
	{
		$configs = $this->load->settings('page');
		echo '<pre>';
		print_r($configs);
	}

	public function testAction()
	{
		$this->data['name'] = ' Don Myers ';
		$this->data['age'] = ' 23 ';
		$this->data['id'] = 123;

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
		$x = $this->validate->map($rules,$output,$this->data);

		var_dump($output);

		var_dump($x);

		echo 'filter'.chr(10);

		$this->data = ' Don Myers ';
		$filter = 'trim|strtolower|base64_encode';

		$isgood = $output = $this->validate->filter($filter,$this->data);

		var_dump($isgood);
		var_dump($this->data);
	}
}