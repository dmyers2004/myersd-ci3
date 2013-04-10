<?php defined('BASEPATH') OR exit('No direct script access allowed');

class authController extends MY_PublicController {

	public $validate = array(
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|xss_clean|filter_str[72]',
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'trim|required|xss_clean|filter_str[72]',
		),
		array(
			'field' => 'remember',
			'label' => 'Remember Me',
			'rules' => 'integer|filter_int[1]',
			'default' => 0,
		)
	);
	
	public function indexAction() {
		$this->load->template('/admin/auth/index');
	}

	public function loginValidatePostAjaxAction() {
		$this->load->library('validator');

		$this->load->json($this->validator->post($this->validate));
	}

	public function loginPostAction() {
		if ($this->input->map($this->validate,$this->data)) {
			if ($this->tank_auth->login($this->data['email'], $this->data['password'], $this->data['remember'], false, true)) {
				$this->flash_msg->green('Login Passed','/admin/dashboard');
			}
		}
		
		$this->flash_msg->red('Login Failed','/admin/auth');
	}

	public function logoutAction() {
		$this->tank_auth->logout();
		redirect('/');
	}
	
}
