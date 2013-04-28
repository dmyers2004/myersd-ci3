<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin controllers are accessible by anyone who is logged in
 * and extend public which load a lot of extra helpers and libs
 * 
 */

class MY_AdminController extends MY_PublicController
{
	public $layout = 'admin/_templates/default';
	
	public $window_title_sub = 'Admin';
	public $controller_model = null;

	public function __construct()
	{
		parent::__construct();
		
		/* check security */
		if (!$this->auth->is_logged_in()) {
			//redirect them to the login page
			$this->flash_msg->red('Access Denied','/admin/auth');
		}

		/* setup a default model */
		if (isset($this->controller_model)) {		
			$model_name = $this->controller_model;
			$this->load->model($model_name);
			$this->controller_model = $this->$model_name;
		}

		$this->load->library('Scaffold');
		
		$this->data('crud',$this->scaffold)
			->data('admin_bar','navbar-inverse')
			->data('controller',$this->controller)
			->data('page_title',$this->page_title)
			->data('page_titles',$this->page_titles)
			->data('page_description',$this->page_description);
	}

} /* end MY_AdminController */
