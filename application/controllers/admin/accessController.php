<?php defined('BASEPATH') OR exit('No direct script access allowed');

class accessController extends MY_AdminController {

	public $controller = 'access';
	public $title = 'Access';
	public $titles = 'Access';
	public $description = '';
	
	public function __construct() {
		parent::__construct();
		
		$this->data('controller',$this->controller)->data('title',$this->title)->data('titles',$this->titles)->data('description',$this->description);
	}

	public function indexAction() {
		$this->data('header',$this->load->view('admin/_partials/table_header',$this->data,true))->data('records',$this->access_model->get_all());

		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}
	
	public function newAction() {
		$this->data('title','New '.$this->title)->data('action','/admin/'.$this->controller.'/new')->data('record',(object)array('id'=>-1,'active'=>1));

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->validate->post($this->access_model->validate));
	}

	public function newPostAction() {
		if ($this->validate->map($this->access_model->validate,$this->data)) {
			if ($this->access_model->insert($this->data)) {
				$this->flash_msg->created($this->title,'/admin/'.$this->controller);
			}
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function editAction($id=null) {
		$this->data('title','Edit '.$this->title)->data('action','/admin/'.$this->controller.'/edit');
		
		if (!$this->input->filter($id,'required|filter_str[5]|exists[access.id]')) {
			redirect('/admin/'.$this->controller);
		}

		$this->data('record',$this->access_model->get($id));

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}
	
	public function editValidatePostAjaxAction() {
		$this->load->json($this->validate->post($this->access_model->validate));
	}

	public function editPostAction() {
		if ($this->validate->map($this->access_model->validate,$this->data)) {
			$this->access_model->update($this->data['id'], $this->data);
			$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;
		
		if ($this->validate->filter($id,'required|filter_str[5]|exists[access.id]') && $this->validate->filter($mode,'required|tf|filter_int[1]')) {
			if ($this->access_model->update($id, array('active'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
	
	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->validate->filter($id,'required|filter_str[5]|exists[access.id]')) {
			$this->access_model->delete($id);
			$this->group_model->delete_access($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}
		
}