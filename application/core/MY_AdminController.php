<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_AdminController extends MY_PublicController
{
	public $layout = 'admin/_templates/default';
	public $subtitle = 'Admin';
	public $default_model = null;

	public function __construct()
	{
		parent::__construct();
		/* check security */
		if (!$this->tank_auth->is_logged_in()) {
			//redirect them to the login page
			$this->flash_msg->red('Access Denied','/admin/auth');
		}

		/* setup a default model */
		if (isset($this->default_model)) {		
			$model_name = $this->default_model;
			$this->default_model = $this->$model_name;
		}
		
		$this->data('controller',$this->controller)->data('title',$this->title)->data('titles',$this->titles)->data('description',$this->description);
	}

} /* end MY_AdminController */
