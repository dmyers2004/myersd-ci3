<?php defined('BASEPATH') OR exit('No direct script access allowed');

class authController extends MY_PublicController {

	public function indexAction() {
		$this->load->template('/admin/auth/index',$this->data);
	}

	public function loginPostAction() {
		if ($this->form_validate() === false) {
			if ($this->tank_auth->login($this->input->post('login'), $this->input->post('password'), $this->input->post('remember',0), false, true)) {
				$this->flash_msg->green('Login Passed','/admin/dashboard');
			}
		}
		
		$this->flash_msg->red('Login Failed','/admin/auth');
	}

	public function logoutAction() {
		$this->tank_auth->logout();
		redirect('/');
	}
	
	protected function form_validate() {
		$json = $this->ajax_validate();
		return $json['err'];
	}
	
	protected function ajax_validate() {
		$json = array();

		$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('remember', 'Remember me', 'integer');

		$this->form_validation->set_error_delimiters('', '<br/>');

		$json['err'] = !$this->form_validation->run();

		$errors = validation_errors();

		$json['errors'] = '<strong id="form-error-shown">Validation Error'.((count(explode('<br/>',$errors)) < 3) ? '' : 's').'</strong><br/>'.$errors;

		return $json;
	}
}
