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

		$this->data['records'] = $this->flexi_auth->get_users()->result();
		$this->get_groups();
		
		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}
	
	/* create new form */
	public function newAction() {
		$this->data['title'] = 'New '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/new';
	
		$this->data['record'] = (object)array('uacc_active'=>1,'uacc_id'=>-1);
		$this->get_groups();

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

			$email = $username = $this->input->post('uacc_email');
			$password = $this->input->post('uacc_password');
			$group_id = $this->input->post('uacc_group_fk');
			$activate = $this->input->post('uacc_active');

			$user_data = array();
			$this->input->map($user_data,'cd_first_name,cd_last_name');
						
			if ($this->flexi_auth->insert_user($email, $username, $password, $user_data, $group_id, $activate)) {
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
		
		if ($this->input->filter($id,'trim|integer|filter_int[5]|exists[user_accounts.uacc_id]',true)) {
			$data['err'] = false;
			if ($this->flexi_auth->delete_user($id)) {
				$data['err'] = false;
			}
		}
 		
		$this->load->json($data);
	}
	
	/* Internal */
	protected function get_groups() {
		$dbc = $this->flexi_auth->get_groups(array('ugrp_id','ugrp_name'))->result();
		foreach ($dbc as $dbr) {
			$this->data['group_options'][$dbr->ugrp_id] = $dbr->ugrp_name;
		}	
	}
	
	protected function form_validate() {
		$json = $this->ajax_validate();
		return $json['err'];
	}
	
	protected function ajax_validate() {
		$json = array();

		$id = $this->input->post('uacc_id');
		$this->form_validation->set_rules('cd_first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('cd_last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('uacc_email', 'Email', 'required|valid_email|unique[user_accounts.uacc_email.uacc_id.'.$id.']');
		$this->form_validation->set_rules('uacc_group_fk', 'Group', 'required|integer');
		$this->form_validation->set_rules('uacc_id', 'Id', 'required|integer');

		if ($this->input->post('uacc_id') == '-1' || ($this->input->post('uacc_password').$this->input->post('uacc_password_confirm') != '')) {
			$this->form_validation->set_rules('uacc_password', 'Password', 'required|min_length[8]|max_length[32]|matches[uacc_password_confirm]');
			$this->form_validation->set_rules('uacc_password_confirm', 'Confirmation Password', 'required');
		}

		$this->form_validation->set_error_delimiters('', '<br/>');

		$json['err'] = !$this->form_validation->run();

		$errors = validation_errors();

		$json['errors'] = '<strong id="form-error-shown">Validation Error'.((count(explode('<br/>',$errors)) < 3) ? '' : 's').'</strong><br/>'.$errors;

		return $json;
	}
}