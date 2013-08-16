<?php defined('BASEPATH') OR exit('No direct script access allowed');

class validateController extends MY_PublicController
{
	public function indexAction()
	{
		echo '<p><a href="/validate/test1">test 1</a></p>';
	}

	public function test1Action() {

		$output = 'adadad';

		$rule = 'alpha';

		$noerr = $this->input->filter($rule,$output,'Test Field',false);

		echo '<pre>';
		if ($noerr) {
			echo 'No Error'.chr(10);
		} else {
			echo 'Error'.chr(10).'Errors:'.chr(10);
			print_r($this->form_validation->error_array());
		}
		echo 'Output:'.chr(10);
		var_dump($output);
	}

	public function test2Action() {

		$output = '';

		$rule = 'default[cat]';

		$noerr = $this->input->filter($rule,$output,'Test Field',false);

		echo '<pre>';
		if ($noerr) {
			echo 'No Error'.chr(10);
		} else {
			echo 'Error'.chr(10).'Errors:'.chr(10);
			print_r($this->form_validation->error_array());
		}
		echo 'Output:'.chr(10);
		var_dump($output);
	}

	public function test3Action() {

		$output = ' hello world ';

		$rule = 'trim|alpha';

		$noerr = $this->input->filter($rule,$output,'Test Field',false);

		echo '<pre>';
		if ($noerr) {
			echo 'No Error'.chr(10);
		} else {
			echo 'Error'.chr(10).'Errors:'.chr(10);
			print_r($this->form_validation->error_array());
		}
		echo 'Output:'.chr(10);
		var_dump($output);
	}

	public function test4Action() {
		
		$rules = array(
			'id' => array('field'=>'id','label'=>'Id','rules'=>'required|filter_str[5]','filter'=>'trim|integer|filter_int[5]|exists[access.id]'),
			'resource' => array('field'=>'resource','label'=>'Resource','rules'=>'required|filter_str[128]'),
			'description' => array('field'=>'description','label'=>'Description','rules'=>'required|filter_str[128]'),
			'active' => array('field'=>'active','dbfield'=>'dbactive','label'=>'Active','rules'=>'default[0]|filter_int[1]'),
			'type' => array('field'=>'type','label'=>'Type','rules'=>'default[0]|filter_int[1]'),
			'module_name' => array('field'=>'module_name','dbfield'=>'db_module_name','label'=>'Module Name','rules'=>'filter_str[32]')
		);

		$output = array();

		$input = array(
			'id' => 23,
			'resource' => 'Donald Myers',
			'description' => 'Ansel Adams 1941-1942',
			'active' => '',
			'type' => '',
			'module_name' => 'Ansel Adams The Mural Project 1941-1942'
		);

		$noerr = $this->input->map($rules,$output,$input,false);

		echo '<pre>';
		if ($noerr) {
			echo 'No Error'.chr(10);
		} else {
			echo 'Error'.chr(10).'Errors:'.chr(10);
			print_r($this->form_validation->error_array());
		}
		echo 'Output:'.chr(10);
		var_dump($output);
	}

	public function test5Action() {
		
		$rules = array(
			'id' => array('field'=>'id','label'=>'Id','rules'=>'required|filter_str[5]','filter'=>'trim|integer|filter_int[5]')
		);

		$output = array();

		$input = array(
			'id' => 23,
			'resource' => 'Donald Myers',
			'description' => 'Ansel Adams 1941-1942',
			'active' => '',
			'type' => '',
			'module_name' => 'Ansel Adams The Mural Project 1941-1942'
		);

		$noerr = $this->input->filter($rules,$output,$input,false);

		echo '<pre>';
		if ($noerr) {
			echo 'No Error'.chr(10);
		} else {
			echo 'Error'.chr(10).'Errors:'.chr(10);
			print_r($this->form_validation->error_array());
		}
		echo 'Output:'.chr(10);
		var_dump($output);
	}


}