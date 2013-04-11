<?php defined('BASEPATH') OR exit('No direct script access allowed');

class authController extends MY_PublicController {

	public $path = '/admin/auth/';	

	public function indexAction() {
		$this->load->template($this->path.'index');
	}

	public function loginValidatePostAjaxAction() {
		$this->load->json($this->user_model->validate_login());
	}

	public function loginPostAction() {
		if ($this->input->map($this->user_model->validate,$this->data)) {
			if ($this->tank_auth->login($this->data['email'], $this->data['password'], $this->data['remember'], false, true)) {
				$this->flash_msg->green('Login Passed','/admin/dashboard');
			}
		}
		
		$this->flash_msg->red('Login Failed',$this->path);
	}

	public function logoutAction() {
		$this->tank_auth->logout();
		redirect('/');
	}
	
}
