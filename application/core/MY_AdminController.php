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
	public $controller_path = '';

	public function __construct()
	{
		parent::__construct();

		/* check security */
		if (!$this->auth->is_logged_in()) {
			// redirect them to the login page
			$this->flash_msg->denied('login');
		}

		/* can they access this page based on there permissions namespace is /url/... */
		if (!$this->auth->has_role_by_group('/url/'.$this->page->data('route')))
		{
			// redirect them to the last page they where on
			$this->flash_msg->denied($this->session->userdata('history-1'));
		}

		/* setup a default model - this is really just for the "scaffolding" built into admin */
		if (isset($this->controller_model)) {
			$model_name = $this->controller_model;
			$this->load->model($model_name);
			$this->controller_model = $this->$model_name;
		}

		/* load the page admin config */
		$this->page
			->set('controller_path',$this->controller_path)
			->set('controller',$this->controller)
			->set('content_title',$this->content_title)
			->set('content_titles',$this->content_titles)
			->config('admin');
	}

} /* end MY_AdminController */
