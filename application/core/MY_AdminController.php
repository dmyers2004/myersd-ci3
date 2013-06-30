<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * AdminController is accessible by anyone who is logged in
 * and extends PublicController which has the abilities to autoload
 * helpers, libraries, models
 *
 */

class MY_AdminController extends MY_PublicController
{

	/* your basic scaffolding */
	public $controller_model = null;
	public $controller = '';
	public $page_title = '';
	public $page_titles = '';

	public function __construct()
	{
		parent::__construct();

		/* check security */
		if (!$this->auth->is_logged_in()) {
			//redirect them to the login page
			$this->flash_msg->denied('login');
		}

		/* !todo now let's check ACL /url/ */
		if (!$this->auth->has_role_by_group('/nav/'.getData('route')))
		{
			//redirect them to the login page
			$this->flash_msg->denied('login');
		}

		/* setup a default model */
		if (isset($this->controller_model)) {
			$model_name = $this->controller_model;
			$this->load->model($model_name);
			$this->controller_model = $this->$model_name;
		}

		$this->page
			->load('admin');
	}

} /* end MY_AdminController */
