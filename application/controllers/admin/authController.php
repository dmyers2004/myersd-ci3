<?php defined('BASEPATH') OR exit('No direct script access allowed');

class authController extends MY_PublicController
{
	public $controller_path = '/admin/auth/';

	public function indexAction()
	{
		$this->page->build($this->controller_path.'index');
	}

	public function loginValidatePostAction()
	{
		$this->load->json($this->user_model->validate_login());
	}

	public function loginPostAction()
	{
		if ($this->input->map($this->user_model->login_validate,$this->data)) {
			if ($this->auth->login($this->data['email'], $this->data['password'], $this->data['remember'], false, true)) {
				$this->flash_msg->green('Login Passed','/admin/dashboard');
			}
		}

		$this->flash_msg->red('Login Failed',$this->controller_path);
	}

	public function logoutAction()
	{
		$this->auth->logout();
		redirect('/');
	}

}
