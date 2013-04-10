<?php defined('BASEPATH') OR exit('No direct script access allowed');

class groupController extends MY_AdminController {

	public $controller = 'group';
	public $title = 'Group';
	public $titles = 'Groups';
	public $description = '';
	public $id_filter = 'trim|integer|filter_int[5]|exists[groups.id]';
	
	public function __construct() {
		parent::__construct();
		
		$this->data('controller',$this->controller)->data('title',$this->title)->data('titles',$this->titles)->data('description',$this->description);
	}

	public function indexAction() {
		$this->data('header',$this->load->view('admin/_partials/table_header',$this->data,true))->data('records',$this->group_model->get_all());

		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}
	
	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action','/admin/'.$this->controller.'/new')
			->data('record',(object)array('id'=>-1))
			->data('my_access',array())
			->data('all_access',$this->format_privileges($this->access_model->get_all()));
		
		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->group_model->validate($this->group_model->validate));
	}

	public function newPostAction() {
		$data = array();
		if ($this->input->map($this->group_model->validate,$data)) {
			if ($id = $this->group_model->insert($data)) {
				$this->update_privilege($id);
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
			->data('record',$this->group_model->get($id))
			->data('all_access',$this->format_privileges($this->access_model->get_all()));

		$privileges = $this->group_model->get_group_access($id);
		foreach ($privileges as $record) {
			$this->data['my_access'][$record->access_id] = true;
		}

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}
	
	public function editValidatePostAjaxAction() {
		$this->load->json($this->group_model->validate($this->group_model->validate));
	}
	
	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->input->post('id');
		$this->input->filter($id,$this->id_filter,false);
	
		$data = array();
		
		if ($this->input->map($this->group_model->validate,$data)) {
			$this->group_model->update($data['id'],$data);
			$this->update_privilege($data['id']);
			$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}
	
	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->input->filter($id,$this->id_filter)) {
			$this->group_model->delete($id);
			$this->group_model->delete_group_access($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}
	
	protected function format_privileges($privileges) {
		$formatted = array();
		foreach ($privileges as $record) {
			$resource = $record->resource;
			$len = strpos($resource,'/',1);
			if ($len === false) {
				$len = strpos($resource,' ',1);
			}
			$formatted[trim(substr($resource, 0, $len),' /')][] = $record;
		}

		return $formatted;
	}

	protected function update_privilege($group_id) {
		$this->group_model->delete_group_access($group_id);
		foreach ($this->input->post('access') as $id => $foo) {
			$this->group_model->insert_group_access($id, $group_id);			
		}
	}

		
}