<?php defined('BASEPATH') OR exit('No direct script access allowed');

class accessController extends MY_AdminController {

	public $controller = 'access';
	public $title = 'Access';
	public $titles = 'Access';
	public $description = '';
	public $id_filter = 'trim|integer|filter_int[5]|exists[access.id]';
	
	public function __construct() {
		parent::__construct();
		
		$this->data('controller',$this->controller)
			->data('title',$this->title)
			->data('titles',$this->titles)
			->data('description',$this->description);
	}

	public function indexAction() {
		$this->data('header',$this->load->view('admin/_partials/table_header',$this->data,true))
			->data('records',$this->access_model->get_all());

		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}
	
	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action','/admin/'.$this->controller.'/new')
			->data('record',(object)array('id'=>-1,'active'=>1));

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->access_model->validate());
	}

	public function newPostAction() {
		$data = array();
		if ($this->input->map($this->access_model->validate, $data)) {
			if ($this->access_model->insert($data)) {
				$this->flash_msg->created($this->title,'/admin/'.$this->controller);
			}
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function editAction($id=null) {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->input->filter($id,$this->id_filter,false);
	
		$this->data('title','Edit '.$this->title)
			->data('action','/admin/'.$this->controller.'/edit')
			->data('record',$this->access_model->get($id));

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}
	
	public function editValidatePostAjaxAction() {
		$this->load->json($this->access_model->validate());
	}

	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->input->filter($id,$this->id_filter,false);
	
		$data = array();
		if ($this->input->map($this->access_model->validate, $data)) {
			$this->access_model->update($data['id'], $data);
			$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;
		
		if ($this->input->filter($id,$this->id_filter) && $this->input->filter($mode,'required|tf|filter_int[1]')) {
			if ($this->access_model->update($id, array('active'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
	
	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->input->filter($id,$this->id_filter)) {
			$this->access_model->delete($id);
			$this->group_model->delete_access($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}
		
}