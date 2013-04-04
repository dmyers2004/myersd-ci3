<?php defined('BASEPATH') OR exit('No direct script access allowed');

class settingsController extends MY_AdminController {

	public $controller = 'settings';
	public $title = 'Setting';
	public $titles = 'Settings';
	public $description = '';
	
	public function __construct() {
		parent::__construct();
		
		$this->data['controller'] = $this->controller;
		$this->data['title'] = $this->title;
		$this->data['titles'] = $this->titles;
		$this->data['description'] = $this->description;

		$this->load->model('settings_model');
	}

	public function indexAction() {
		$this->data['header'] = $this->load->view('admin/_partials/table_header',$this->data,true);

		$this->data['records'] = $this->settings_model->order_by('option_group')->get_all();

		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}

	public function newAction() {
		$this->data['title'] = 'New '.$this->title;
		$this->data['action'] =	'/admin/'.$this->controller.'/new';

		$this->data['record'] = (object)array('option_id'=>-1);
		$this->data['option_group'] = $this->settings_model->dropdown('option_group','option_group');

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->settings_model->ajax_validate());
	}

	public function newPostAction() {
		$data = array();
		$this->input->map($data,'option_name,option_value,option_group,auto_load>0');

		if ($this->settings_model->insert($data)) {
			$this->flash_msg->created($this->title,'/admin/'.$this->controller);
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function editAction($id=null) {
		$this->data['title'] = 'Edit '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/edit';
		$this->data['record'] = $this->settings_model->get($id);
		$this->data['option_group'] = $this->settings_model->dropdown('option_group','option_group');

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function editValidatePostAjaxAction() {
		$this->load->json($this->settings_model->ajax_validate());
	}

	public function editPostAction() {
		$data = array();
		$id = $this->input->post('option_id');

		$this->input->map($data,'option_name,option_value,option_group,auto_load>0');

		if ($this->input->filter($id,'trim|integer|filter_int[5]',true)) {
			if ($this->settings_model->update($id,$data)) {
				$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
			}
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function deleteAjaxAction($id=null) {
		$json['err'] = true;

		/* can they delete? */
		if ($this->input->filter($id,'trim|integer|filter_int[5]',true)) {
			if ($this->settings_model->delete($id)) {
				$json['err'] = false;
			}
		}
		
		$this->load->json($json);
	}

	public function autoloadAjaxAction($id=null,$mode=null) {
		$json['err'] = true;

		if ($this->input->filter($id,'trim|integer|filter_int[5]',true) && $this->input->filter($mode,'trim|tf|filter_int[1]',true)) {
			if ($this->settings_model->update_autoload($id, $mode)) {
				$json['err'] = false;
			}
		}

		$this->load->json($json);
	}
}
