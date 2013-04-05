<?php defined('BASEPATH') OR exit('No direct script access allowed');

class accessController extends MY_AdminController {

	public $controller = 'access';
	public $title = 'Access';
	public $titles = 'Access';
	public $description = '';
	
	public function __construct() {
		parent::__construct();
		
		$this->data['controller'] = $this->controller;
		$this->data['title'] = $this->title;
		$this->data['titles'] = $this->titles;
		$this->data['description'] = $this->description;
	}

	public function indexAction() {
		$this->data['header'] = $this->load->view('admin/_partials/table_header',$this->data,true);
		$this->data['records'] = $this->flexi_auth->get_privileges()->result();

		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}
	
	public function newAction() {
		$this->data['title'] = 'New '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/new';
	
		$this->data['record'] = (object)array('upriv_id'=>-1);

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->ajax_validate());
	}

	public function newPostAction() {
		if ($this->form_validate() === false) {
			if ($this->flexi_auth->insert_privilege($this->input->post('upriv_name'),$this->input->post('upriv_desc'))) {
				$this->flash_msg->created($this->title,'/admin/'.$this->controller);
			}
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function editAction($id=null) {
		$this->data['title'] = 'Edit '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/edit';
	
		$this->data['record'] = $this->flexi_auth->get_privileges('*',array('upriv_id'=>$id))->row();

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}
	
	public function editValidatePostAjaxAction() {
		$this->load->json($this->ajax_validate($this->input->post('upriv_id')));
	}

	public function editPostAction() {
		if ($this->form_validate($this->input->post('upriv_id')) === false) {

			$id = $this->input->post('upriv_id');
			$data['upriv_name'] = $this->input->post('upriv_name');
			$data['upriv_desc'] = $this->input->post('upriv_desc');

			if ($this->input->filter($id,'trim|integer|filter_int[5]',true)) {
				if ($this->flexi_auth->update_privilege($id,$data)) {
					$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
				}
			}
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}
	
	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->input->filter($id,'trim|integer|filter_int[5]',true)) {
			$this->flexi_auth->delete_user_group_privilege(array('upriv_groups_upriv_fk'=>$id));
			if ($this->flexi_auth->delete_privilege($id)) {
				$data['err'] = false;
			}
		}
		
		$this->load->json($data);
	}
	
	protected function form_validate() {
		return $this->ajax_validate('err');
	}

	protected function ajax_validate($err=false) {
		$this->form_validation->set_rules('id', 'Id', 'required|integer');
		$this->form_validation->set_rules('resource', 'Resource', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required|xss_clean');

		return $this->form_validation->json($err);
	}
		
}