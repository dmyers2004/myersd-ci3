<?php defined('BASEPATH') OR exit('No direct script access allowed');

class settingController extends MY_AdminController {

	public $controller = 'setting';
	public $title = 'Setting';
	public $titles = 'Settings';
	public $description = 'The settings page is where all module settings are located.';
	public $controller_model = 'setting_model';
	public $path = '/admin/setting/';	
	
	public function indexAction() {
		$this->data('header',$this->load->partial('admin/_partials/table_header'))
			->data('records',$this->controller_model->order_by('option_group')->get_all())
			
			->load->template($this->path.'index');
	}

	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action',$this->path.'new')
			->data('header',$this->load->partial('admin/_partials/form_header'))
			->data('record',(object)array('option_id'=>-1,'active'=>1))
			->data('option_group',$this->controller_model->dropdown('option_group','option_group'))

			->load->template($this->path.'form');
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
			->data('header',$this->load->partial('admin/_partials/form_header'))
			->data('record',$this->controller_model->get($id))
			->data('option_group',$this->controller_model->dropdown('option_group','option_group'))

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

	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->controller_model->filter_id($id)) {
			$this->controller_model->delete($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}

	public function autoloadAjaxAction($id=null,$mode=null) {
		$data['err'] = true;

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($mode)) {
			if ($this->controller_model->update($id, array('auto_load'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
}
