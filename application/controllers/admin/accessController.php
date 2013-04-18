<?php defined('BASEPATH') OR exit('No direct script access allowed');

class accessController extends MY_AdminController {

	public $controller = 'access';
	public $title = 'Access';
	public $titles = 'Access';
	public $description = '';
	public $controller_model = 'access_model';
	public $path = '/admin/access/';	

	public function indexAction() {
		$this->data('header',$this->load->partial('admin/_partials/table_header'))
			->data('records',$this->controller_model->get_all())
			
			->load->template($this->path.'index');
	}
	
	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action',$this->path.'new')
			->data('record',(object)array('id'=>-1,'active'=>1))
			->data('header',$this->load->partial('admin/_partials/form_header'))
			->data('endform',$this->load->partial('admin/_partials/endform'))

			->template($this->path.'form');
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->controller_model->validate());
	}

	public function newPostAction() {
		if ($this->controller_model->map($this->data)) {
			if ($this->controller_model->insert($this->data)) {
				$this->flash_msg->created($this->title,$this->path);
			}
		}

		$this->flash_msg->fail($this->title,$this->path);
	}

	public function editAction($id=null) {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->controller_model->filter_id($id,false);
	
		$this->data('title','Edit '.$this->title)
			->data('action',$this->path.'edit')
			->data('record',$this->controller_model->get($id))
			->data('header',$this->load->partial('admin/_partials/form_header'))
			->data('endform',$this->load->partial('admin/_partials/endform'))
			
			->load->template($this->path.'form');
	}
	
	public function editValidatePostAjaxAction() {
		$this->load->json($this->controller_model->validate());
	}

	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->controller_model->filter_id($id,false);
	
		if ($this->controller_model->map($this->data)) {
			$this->controller_model->update($this->data['id'], $this->data);
			$this->flash_msg->updated($this->title,$this->path);
		}
		
		$this->flash_msg->fail($this->title,$this->path);
	}

	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;
		
		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($mode)) {
			if ($this->controller_model->update($id, array('active'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
	
	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->controller_model->filter_id($id)) {
			$this->controller_model->delete($id);
			$this->group_model->delete_access($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}
		
}