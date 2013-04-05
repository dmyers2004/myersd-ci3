<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_AdminController extends MY_PublicController
{
	public $layout = 'admin/_templates/default';
	public $subtitle = 'Admin';

	public function __construct()
	{
		parent::__construct();
		/* check security */
		if (!$this->tank_auth->is_logged_in()) {
			//redirect them to the login page
			$this->flash_msg->red('Access Denied','/admin/auth');
		}
	}

} /* end MY_AdminController */
