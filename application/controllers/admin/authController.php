<?php defined('BASEPATH') OR exit('No direct script access allowed');

class authController extends MY_PublicController
{
	public $controller_path = '/admin/auth/';

	public function indexAction()
	{
		$this->page->build();
	}

	public function forgotAction()
	{
		$this->page->build();
	}

	public function resetAction() {
		$this->page->build();
	}

	public function forgotValidatePostAction()
	{
		$this->load->json($this->user_model->validate_email());
	}

	public function forgotPostAction()
	{
		if ($this->input->map($this->user_model->email_validate,$this->data)) {
			if ($this->auth->forgot_password($this->data['email'])) {

				$this->data['from'] = $this->config->item('website_email', 'tank_auth');
				$this->data['to'] = $this->data['email'];
				$this->data['subject'] = 'Forgot email';
				$this->data['template'] = 'forgot_password';
				$this->data['site_name'] = $this->config->item('website_name', 'tank_auth');

				/* for templates */
				$this->data['link'] = base_url();
				
				$this->send_email($this->data);

				$this->flash_msg->blue('Email Sent','/admin/auth');
			}
		}

		$this->flash_msg->red('No account associated with that password','/admin/auth/forgot');
	}

	public function registerAction()
	{
		$this->page
			->js('/assets/js/page/admin_auth_register.js')
			->build();
	}

	public function registerValidatePostAction()
	{
		$this->load->json($this->user_model->validate_register());
	}

	public function registerPostAction()
	{
		if ($this->input->map($this->user_model->register_validate,$this->data)) {
			/* send activation email? */
			$email_activation = $this->config->item('email_activation', 'auth');
			$default_group_id = $this->config->item('default_group_id', 'auth');
			
			/* did they set the default group id */
			if ($default_group_id == null) {
				/* you forgot to set the default group id! */
				log_message('error','config/auth.php default_group_id not set');
				$this->flash_msg->red('Registration Failed','/');
			}
			
			if (!is_null($this->auth->create_user($this->data['username'], $this->data['email'], $this->data['password'], $default_group_id, $email_activation))) {

				if ($email_activation) { // send "activate" email
					$this->data['activation_period'] = $this->config->item('email_activation_expire', 'auth') / 3600;
					$this->data['template'] = 'activate';

					unset($this->data['password']); // Clear password (just for any case)
					
					$this->send_email($this->data);

					$this->flash_msg->blue('Email Sent','/admin/auth');
				} else {
					if ($this->config->item('email_account_details', 'auth')) {	// send "welcome" email
						$this->data['template'] = 'welcome';
						unset($data['password']); // Clear password (just for any case)
						$this->send_email($this->data);
						$this->flash_msg->blue('Welcome Email Sent','/admin/auth');
					}
					
					redirect('/admin/auth');
				}
				
				redirect('/admin/');
			}

		}
		
		$this->flash_msg->red('Registration Failed','/');
	}

	public function loginValidatePostAction()
	{
		$this->load->json($this->user_model->validate_login());
	}

	public function loginPostAction()
	{
		if ($this->input->map($this->user_model->login_validate,$this->data)) {
			if ($this->auth->login($this->data['email'], $this->data['password'], $this->data['remember'], false, true)) {
				$this->flash_msg->blue('Welcome','/admin/dashboard');
			}
		}

		$this->flash_msg->red('Login Failed',$this->controller_path);
	}

	public function logoutAction()
	{
		$this->auth->logout();
		$this->flash_msg->blue('You are now logged out','/');
	}
	
	private function send_email() {
		$this->load->library('email');
	
		$this->data['from_long'] = ($this->data['from_long']) ? $this->data['from_long'] : $this->data['from'];
		$this->data['reply_to'] = ($this->data['reply_to']) ? $this->data['reply_to'] : $this->data['from'];
		$this->data['reply_to_long'] = ($this->data['reply_to_long']) ? $this->data['reply_to_long'] : $this->data['reply_to'];
	
		$this->email->from($this->data['from'], $this->data['from_long']);
		$this->email->reply_to($this->data['reply_to'], $this->data['reply_to_long']);
		$this->email->to($this->data['to']);
		$this->email->subject(merge($this->data['subject'],$this->data,true));
		$this->email->message(merge('admin/_email_templates/'.$this->data['template'].'-html',$this->data));
		$this->email->set_alt_message(merge('admin/_email_templates/'.$this->data['template'].'-txt',$this->data));
		$this->email->send();
	}

}
