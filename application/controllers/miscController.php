<?php defined('BASEPATH') OR exit('No direct script access allowed');

class miscController extends MY_PublicController
{
	public function indexAction()
	{
		$this->page->build('main/index');
	}

	public function chromephpAction()
	{
		$this->load->helper('chromephp');
		
		ChromePhp::log('Hello console!');
		ChromePhp::log($_SERVER);
		ChromePhp::warn('something went wrong!');
		
		ChromePhp::log($this->settings->get_settings());
		
		$this->page->build('main/index');
	}
	
	public function newformAction() {
		$this->load->model('user_model');

		$this->page
			->set('title','New Form Test')
			->set('record',$this->user_model->get_user(3))
			->set('group_options',$this->_get_groups())
			->build();
	}
	
	public function newformValidateAjaxPostAction()
	{
		// {"err":false,"errors":"","errors_array":[]}
		$this->output->json(array('err'=>false,'errors'=>'','errors_array'=>array()));
	}

	/* create new form post */
	public function newformPostAction()
	{
		sf_process();
	}

	protected function _get_groups()
	{
		$group = array();
		$dbc = $this->group_model->get_all();
		foreach ($dbc as $dbr) {
			$group[$dbr->id] = $dbr->name;
		}
		return $group;
	}

}

$foo = array();


/* table.column.primary_key.primary_id */
function sfn($input) {
	global $foo;

	$foo[] = $input;

	$fields = explode('.',$input);
	return $fields[1];

}

function sf_finished() {
	global $foo;
	$bar = serialize($foo);
	echo '<input type="hidden" name="smartform[]" value="'.base64_encode($bar).'">';
	$foo = array();
}

function sf_process() {
	echo '<pre>';
	
	$ci = get_instance();
	
	$posts = $ci->input->post('smartform');
	
	$output = array();
	
	foreach ($posts as $smart_form) {
		$form_elements = unserialize(base64_decode($smart_form));
		print_r($form_elements);
		foreach ($form_elements as $value) {
			$x = explode('.', $value);
			$output[$x[1]] = $ci->input->post($x[1]);
		}
	}

	print_r($output);
}