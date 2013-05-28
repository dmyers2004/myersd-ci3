<?php defined('BASEPATH') OR exit('No direct script access allowed');

class dashboardController extends MY_AdminController
{
	public function indexAction()
	{
		$this->page->build();
	}

	public function upAction()
	{
		$this->load->library('migration');

		$this->migration->version(2);
	}

}
