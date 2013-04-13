<?php defined('BASEPATH') OR exit('No direct script access allowed');

class groupController extends MY_AdminController {

	public $controller = 'group';
	public $title = 'Group';
	public $titles = 'Groups';
	public $description = '';
	public $default_model = 'group_model';
	public $path = '/admin/group/';		

	public function indexAction() {
		$this->data('header',$this->load->partial('admin/_partials/table_header'))
			->data('records',$this->default_model->get_all())
			->load->template($this->path.'index');
	}
	
	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action',$this->path.'new')
			->data('record',(object)array('id'=>-1))
			->data('my_access',array())
			->data('all_access',$this->format_privileges($this->access_model->get_all()))
			->data('header',$this->load->partial('admin/_partials/form_header'))

			->load->template($this->path.'form');
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->default_model->validate());
	}

	public function newPostAction() {
		if ($this->default_model->map($this->data)) {
			if ($id = $this->default_model->insert($this->data)) {
				$this->update_privilege($id);
				$this->flash_msg->created($this->title,$this->path);
			}
		}

		$this->flash_msg->fail($this->title,$this->path);
	}

	public function editAction($id=null) {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->default_model->filter_id($id,false);

		$this->data('title','Edit '.$this->title)
			->data('action',$this->path.'edit')
			->data('record',$this->default_model->get($id))
			->data('header',$this->load->partial('admin/_partials/form_header'))
			->data('all_access',$this->format_privileges($this->access_model->get_all()));

		$privileges = $this->default_model->get_group_access($id);
		foreach ($privileges as $record) {
			$access[$record->access_id] = true;
		}
		
		$this->data('my_access',(array)$access)
			->load->template($this->path.'form');
	}
	
	public function editValidatePostAjaxAction() {
		$this->load->json($this->default_model->validate());
	}
	
	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->default_model->filter_id($id,false);
	
		if ($this->default_model->map($this->data)) {
			$this->default_model->update($this->data['id'],$this->data);
			$this->update_privilege($this->data['id']);
			$this->flash_msg->updated($this->title,$this->path);
		}
		
		$this->flash_msg->fail($this->title,$this->path);
	}
	
	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->default_model->filter($id)) {
			$this->default_model->delete($id);
			$this->default_model->delete_group_access($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}
	
	protected function format_privileges($privileges) {
		$formatted = array();
		foreach ($privileges as $record) {
		
			$name = '';
			$resource = $record->resource;
			
			$len = strpos($resource,'/',1);
			
			if ($len === false) {
				$len = strpos($resource,' ',1);
			}
			
			if ($len === false) {
				$name = '*Generic';
			}
			
			$namespace = ($name != '') ? $name : trim(substr($resource, 0, $len),' /');
			
			$formatted[$namespace][] = $record;
		}

		ksort($formatted);

		return $formatted;
	}

	protected function update_privilege($group_id) {
		$this->default_model->delete_group_access($group_id);
		foreach ($this->input->post('access') as $id => $foo) {
			$this->default_model->insert_group_access($id, $group_id);			
		}
	}

		
}