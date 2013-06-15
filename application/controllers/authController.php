<?php defined('BASEPATH') OR exit('No direct script access allowed');

class authController extends MY_PublicController
{
	public $controller_path = '/auth/';

	public function __construct() {
		parent::__construct();
		$this->load->library('scaffold');
		$this->page->add('crud',$this->scaffold);
	}

	/* standard login */
	public function indexAction()
	{
		$this->page
			->add('rememberme',$this->input->cookie($this->config->item('autologin_cookie_name', 'auth')))
			->build();
	}

	public function loginValidateAjaxPostAction()
	{
		$this->load->json($this->user_model->validate_login());
	}

	public function loginPostAction()
	{
		if ($this->user_model->map_login($this->data)) {
			if ($this->auth->login($this->data['email'], $this->data['password'], $this->data['remember'], false, true)) {
				$this->flash_msg->blue('Welcome','admin home');
			}
		}

		$this->flash_msg->red('Login Failed',$this->controller_path);
	}

	/* logout */
	public function logoutAction()
	{
		$this->auth->logout();
		$this->flash_msg->blue('You are now logged out','home');
	}

	/* register new user */
	public function registerAction()
	{
		$this->page
			->js('/assets/js/page/admin_auth_register.js')
			->build();
	}

	public function registerValidateAjaxPostAction()
	{
		$this->load->json($this->user_model->validate_register());
	}

	public function registerPostAction()
	{
		if ($this->user_model->map_register($this->data)) {
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

				// Clear password (just incase)
				unset($data['password']);
				unset($data['repeat_password']);

				if ($email_activation) { // send "activate" email
					$this->data['template'] = 'activate';
					$this->data['activation_period'] = $this->config->item('email_activation_expire', 'auth') / 3600;

					$this->send_email($this->data);
					$this->flash_msg->blue('Registration Processed<br>Verification Email Sent','login');
				} else {
					if ($this->config->item('email_account_details', 'auth')) {	// send "welcome" email
						$this->data['template'] = 'welcome';
						
						$this->send_email($this->data);
						$this->flash_msg->blue('Registration Processed<br>Welcome Email Sent','login');
					}
				}
				$this->flash_msg->blue('Registration Processed','login');		
			}

		}
		
		$this->flash_msg->red('Registration Failed','register');
	}

	/* forgot */
	public function forgotAction()
	{
		$this->page
			->build();
	}

	public function forgotValidateAjaxPostAction()
	{
		$this->load->json($this->user_model->validate_email());
	}

	public function forgotPostAction()
	{
		if ($this->user_modelv->map_forgot($this->data)) {
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
	
	/* resend new account email */
		
	public function resend_emailAction()
	{
		$this->page
			->build();
	}

	public function resend_emailValidateAjaxPostAction()
	{
		$this->load->json($this->user_model->validate_email());
	}

	public function resend_emailPostAction()
	{
		if ($this->user_model->map_resend_email($this->data)) {
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

	/* activate new account account */

	public function activateAction($user_id=null,$activation_key=null)
	{
		/* filter input die hard if somebody is messing around */
		$this->auth->filter_activation_key($activation_key); /* the lib generated the activation key so have it filter it */
		$this->user_model->filter_id($user_id); /* the model manages the user id format */

		$this->page
			->data('live',$this->auth->activate_user($user_id, $activation_key))
			->build();
	}
	
	/* reset password */
	public function resetAction() {
		$this->page
			->build();
	}

	public function resetValidateAjaxPostAction()
	{
		$this->load->json($this->user_model->validate_email());
	}

	public function resetPostAction()
	{
	
	} 

	/* support */

	private function send_email() {
		$this->load->library('email');
	
		$this->data['from_long'] = ($this->data['from_long']) ? $this->data['from_long'] : $this->data['from'];
		$this->data['reply_to'] = ($this->data['reply_to']) ? $this->data['reply_to'] : $this->data['from'];
		$this->data['reply_to_long'] = ($this->data['reply_to_long']) ? $this->data['reply_to_long'] : $this->data['reply_to'];
	
		$this->email->from($this->data['from'], $this->data['from_long']);
		$this->email->reply_to($this->data['reply_to'], $this->data['reply_to_long']);
		$this->email->to($this->data['to']);
		$this->email->subject(mergeString($this->data['subject'],$this->data));
		$this->email->message(merge('admin/_email_templates/'.$this->data['template'].'-html',$this->data));
		$this->email->set_alt_message(merge('admin/_email_templates/'.$this->data['template'].'-txt',$this->data));
		$this->email->send();
	}

}
