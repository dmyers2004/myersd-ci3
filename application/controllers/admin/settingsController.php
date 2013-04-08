<?php defined('BASEPATH') OR exit('No direct script access allowed');

class settingsController extends MY_AdminController {

	public $controller = 'settings';
	public $title = 'Setting';
	public $titles = 'Settings';
	public $description = '';
	public $id_filter = 'trim|integer|filter_int[5]|exists[settings.option_id]';

	
	public function __construct() {
		parent::__construct();
		
		$this->data('controller',$this->controller)->data('title',$this->title)->data('titles',$this->titles)->data('description',$this->description);
	}

	public function indexAction() {
		$this->data('header',$this->load->view('admin/_partials/table_header',$this->data,true))
			->data('records',$this->settings_model->order_by('option_group')->get_all());

		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}

	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action','/admin/'.$this->controller.'/new')
			->data('record',(object)array('option_id'=>-1,'active'=>1))
			->data('option_group',$this->settings_model->dropdown('option_group','option_group'));

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->validate->post($this->settings_model->validate));
	}

	public function newPostAction() {
		$data = array();
		
		if ($this->validate->map($this->settings_model->validate, $data)) {
			if ($this->settings_model->insert($data)) {
				$this->flash_msg->created($this->title,'/admin/'.$this->controller);
			}
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function editAction($id=null) {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->validate->filter($id,$this->id_filter,false);

		$this->data('title','Edit '.$this->title)
			->data('action','/admin/'.$this->controller.'/edit')
			->data('record',$this->settings_model->get($id))
			->data('option_group',$this->settings_model->dropdown('option_group','option_group'));

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function editValidatePostAjaxAction() {
		$this->load->json($this->validate->post($this->settings_model->validate));
	}

	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->validate->filter($this->input->post('option_id'),$this->id_filter,false);
	
		$data = array();
		
		if ($this->validate->map($this->settings_model->validate, $data)) {
			$this->settings_model->update($data['id'], $data);
			$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->validate->filter($id,$this->id_filter)) {
			$this->settings_model->delete($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}

	public function autoloadAjaxAction($id=null,$mode=null) {
		$data['err'] = true;

		if ($this->validate->filter($id,$this->id_filter) && $this->validate->filter($mode,'required|tf|filter_int[1]')) {
			if ($this->settings_model->update($id, array('auto_load'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
}
