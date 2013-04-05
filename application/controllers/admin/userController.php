<?php defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends MY_AdminController {

	public $controller = 'user';
	public $title = 'User';
	public $titles = 'Users';
	public $description = '';
	
	public function __construct() {
		parent::__construct();
		
		$this->data['controller'] = $this->controller;
		$this->data['title'] = $this->title;
		$this->data['titles'] = $this->titles;
		$this->data['description'] = $this->description;
	}
	
	/* index view */
	public function indexAction() {
		$this->data['header'] = $this->load->view('admin/_partials/table_header',$this->data,true);

		$this->data['records'] = $this->tank_auth->get_users();
		$this->data['group_options'] = $this->get_groups();
		
		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}
	
	/* create new form */
	public function newAction() {
		$this->data['title'] = 'New '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/new';
	
		$this->data['record'] = (object)array('activated'=>1,'id'=>-1);
		$this->data['group_options'] = $this->get_groups();

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	/* create new form validation */
	public function newValidatePostAjaxAction() {
		$this->load->json($this->ajax_validate());
	}
	
	/* create new form post */
	public function newPostAction() {
		/* do we have a validation error? */
		if ($this->form_validate() === false) {

			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$group_id = $this->input->post('group_id');
			$activate = $this->input->post('activated');
						
			if ($this->tank_auth->create_user($username, $email, $password, $group_id, false)) {
				$this->flash_msg->created($this->title,'/admin/'.$this->controller);
			}
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	/* edit form */
	public function editAction($id=null) {
		/* are they trying anything fishy? send back to the index */
		$this->input->filter($id,'trim|integer|filter_int[5]|exists[user_accounts.uacc_id]','/admin/'.$this->controller);

		$this->data['title'] = 'Edit '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/edit';

		$this->data['record'] = $this->flexi_auth->get_user_by_id($id)->row();
		
		$this->get_groups();
		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	/* edit form validate */
	public function editValidatePostAjaxAction() {
		$this->load->json($this->ajax_validate());
	}

	/* edit form post */
	public function editPostAction() {
		/* do we have a validation error? */
		if ($this->form_validate() === false) {
			
			$id = $this->input->post('uacc_id');
			
			if ($this->input->filter($id,'trim|integer|filter_int[5]|exists[user_accounts.uacc_id]','/admin/'.$this->controller)) {

				$data = array();
				$this->input->map($data,'cd_first_name,cd_last_name,uacc_email,uacc_group_fk,uacc_active>0');
	
				if ($this->input->post('uacc_password') != '') {
					$data['uacc_password'] = $this->input->post('uacc_password');
				}

				if ($this->flexi_auth->update_user($id, $data)) {
					$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
				}
			}
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}
	
	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;
		
		if ($this->input->filter($id,'trim|integer|filter_int[5]|exists[user_accounts.uacc_id]',true) && $this->input->filter($mode,'trim|tf|filter_int[1]',true)) {
			if ($this->flexi_auth->update_user($id, array('uacc_active'=>$mode))) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
	
	/* ajax delete */
	public function deleteAjaxAction($id=null) {		
		/* can they delete? */
		$data['err'] = true;
		
		if ($this->input->filter($id,'trim|integer|filter_int[5]|exists[users.id]',true)) {
			$data['err'] = false;
			if ($this->flexi_auth->delete_user($id)) {
				$data['err'] = false;
			}
		}
 		
		$this->load->json($data);
	}
	
	/* Internal */
	protected function get_groups() {
		$dbc = $this->group_model->get_all();
		foreach ($dbc as $dbr) {
			$data[$dbr->id] = $dbr->name;
		}
		return (array)$data;
	}
	
	protected function form_validate() {
		return $this->ajax_validate('err');
	}
	
	protected function ajax_validate($err=false) {

		$id = $this->input->post('id');
		$this->form_validation->set_rules('username', 'User Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|unique[users.email.id.'.$id.']');
		$this->form_validation->set_rules('group_id', 'Group', 'required|integer');
		$this->form_validation->set_rules('id', 'Id', 'required|integer');

		if ($this->input->post('id') == '-1' || ($this->input->post('password').$this->input->post('confirm_password') != '')) {
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[32]|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'Confirmation Password', 'required');
		}

		return $this->form_validation->json($err);
	}
}