<?php defined('BASEPATH') OR exit('No direct script access allowed');

class authController extends MY_PublicController
{
	public $controller_path = '/auth/';

	public function indexAction()
	{
		$this->page->build();
	}

	public function resend_emailAction()
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

	public function registerAction()
	{
		$this->page->js('/assets/js/page/admin_auth_register.js')->build();
	}

	public function resend_emailValidatePostAction()
	{
		$this->load->json($this->user_model->validate_email());
	}

	public function forgotValidatePostAction()
	{
		$this->load->json($this->user_model->validate_email());
	}

	public function registerValidatePostAction()
	{
		$this->load->json($this->user_model->validate_register());
	}

	public function loginValidatePostAction()
	{
		$this->load->json($this->user_model->validate_login());
	}

	public function logoutAction()
	{
		$this->auth->logout();
		$this->flash_msg->blue('You are now logged out','home');
	}

	public function resend_emailPostAction()
	{
		if ($this->input->map($this->user_model->email_validate,$this->data)) {
			if ($this->auth->change_email($this->data['email'])) {

				$this->data['from'] = $this->config->item('website_email', 'auth');
				$this->data['to'] = $this->data['email'];
				$this->data['subject'] = 'Activation Email';
				$this->data['template'] = 'activate';
				$this->data['site_name'] = $this->config->item('website_name', 'auth');
				$this->data['link'] = base_url();
				
				$this->send_email($this->data);

				$this->flash_msg->blue('Email Sent','login');
			}
		}

		$this->flash_msg->red('No user found associated with that email','resend login email');
	}

	public function forgotPostAction()
	{
		if ($this->input->map($this->user_model->email_validate,$this->data)) {
			if ($this->auth->forgot_password($this->data['email'])) {

				$this->data['from'] = $this->config->item('website_email', 'auth');
				$this->data['to'] = $this->data['email'];
				$this->data['subject'] = 'Forgot email';
				$this->data['template'] = 'forgot_password';
				$this->data['site_name'] = $this->config->item('website_name', 'auth');
				$this->data['link'] = base_url();
				
				$this->send_email($this->data);

				$this->flash_msg->blue('Email Sent','login');
			}
		}

		$this->flash_msg->red('No account associated with that password','forgot password');
	}

	public function activateAction($user_id=null,$activation_key=null)
	{
		/* filter input die hard if somebody is messing around */	
		$this->input->filter('required|integer',$user_id,false);
		$this->input->filter('required|md5',$activation_key,false);

		$this->page
			->data('live',$this->auth->activate_user($user_id, $activation_key))
			->build();
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
				$this->flash_msg->red('Registration Failed','home');
			}
			
			if (!is_null($this->auth->create_user($this->data['username'], $this->data['email'], $this->data['password'], $default_group_id, $email_activation))) {

				if ($email_activation) { // send "activate" email
					$this->data['activation_period'] = $this->config->item('email_activation_expire', 'auth') / 3600;
					$this->data['template'] = 'activate';

					unset($this->data['password']); // Clear password (just for any case)
					
					$this->send_email($this->data);

					$this->flash_msg->blue('Email Sent','login');
				} else {
					if ($this->config->item('email_account_details', 'auth')) {	// send "welcome" email
						$this->data['template'] = 'welcome';
						unset($data['password']); // Clear password (just for any case)
						$this->send_email($this->data);
						$this->flash_msg->blue('Welcome Email Sent','login');
					}
					
					redirect($this->path['login']);
				}
				
				redirect($this->path['admin home']);
			}

		}
		
		$this->flash_msg->red('Registration Failed','home');
	}

	public function loginPostAction()
	{
		if ($this->input->map($this->user_model->login_validate,$this->data)) {
			if ($this->auth->login($this->data['email'], $this->data['password'], $this->data['remember'], false, true)) {
				$this->flash_msg->blue('Welcome','admin home');
			}
		}

		$this->flash_msg->red('Login Failed',$this->controller_path);
	}

	private function send_email() {
		$this->load->library('email');
	
		$this->data['from_long'] = ($this->data['from_long']) ? $this->data['from_long'] : $this->data['from'];
		$this->data['reply_to'] = ($this->data['reply_to']) ? $this->data['reply_to'] : $this->data['from'];
		$this->data['reply_to_long'] = ($this->data['reply_to_long']) ? $this->data['reply_to_long'] : $this->data['reply_to'];
	
		$this->email->from($this->data['from'], $this->data['from_long']);
		$this->email->reply_to($this->data['reply_to'], $this->data['reply_to_long']);
		$this->email->to($this->data['to']);
		$this->email->subject(merge_string($this->data['subject'],$this->data));
		$this->email->message(merge('admin/_email_templates/'.$this->data['template'].'-html',$this->data));
		$this->email->set_alt_message(merge('admin/_email_templates/'.$this->data['template'].'-txt',$this->data));
		$this->email->send();
	}

}
