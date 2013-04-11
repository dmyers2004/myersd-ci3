<?php defined('BASEPATH') OR exit('No direct script access allowed');

class accessController extends MY_AdminController {

	public $controller = 'access';
	public $title = 'Access';
	public $titles = 'Access';
	public $description = '';
	public $default_model = 'access_model';
	public $path = '/admin/access/';	

	public function indexAction() {
		$this->data('header',$this->load->partial('admin/_partials/table_header'))->data('records',$this->default_model->get_all());

		$this->load->template($this->path.'index');
	}
	
	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action',$this->path.'new')
			->data('record',(object)array('id'=>-1,'active'=>1))
			->data('header',$this->load->partial('admin/_partials/form_header'));

		$this->load->template($this->path.'form');
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->default_model->validate());
	}

	public function newPostAction() {
		if ($this->default_model->map($this->data)) {
			if ($this->default_model->insert($this->data)) {
				$this->flash_msg->created($this->title,$this->path);
			}
		}

		$this->flash_msg->fail($this->title,$this->path);
	}

	public function editAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->default_model->filter_id($this->input->post('id'),false);
	
		$this->data('title','Edit '.$this->title)
			->data('action',$this->path.'edit/'.$id)
			->data('record',$this->default_model->get($id))
			->data('header',$this->load->partial('admin/_partials/form_header'));

		$this->load->template($this->path.'form');
	}
	
	public function editValidatePostAjaxAction() {
		$this->load->json($this->default_model->validate());
	}

	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->default_model->filter_id($this->input->post('id'),false);
	
		if ($this->default_model->map($this->data)) {
			$this->default_model->update($data['id'], $this->data);
			$this->flash_msg->updated($this->title,$this->path);
		}
		
		$this->flash_msg->fail($this->title,$this->path);
	}

	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;
		
		if ($this->default_model->filter_id($id) && $this->default_model->filter_mode($mode)) {
			if ($this->default_model->update($id, array('active'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
	
	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->default_model->filter_id($id)) {
			$this->default_model->delete($id);
			$this->group_model->delete_access($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}
		
}