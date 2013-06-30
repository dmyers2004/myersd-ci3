<?php defined('BASEPATH') OR exit('No direct script access allowed');

class miscController extends MY_PublicController
{
	public function indexAction()
	{
		$this->page->build('main/index');
	}

	public function chromephpAction()
	{
		$this->load->helper('chromephp');
		
		ChromePhp::log('Hello console!');
		ChromePhp::log($_SERVER);
		ChromePhp::warn('something went wrong!');
		
		ChromePhp::log($this->settings->get_settings());
		
		$this->page->build('main/index');
	}

}

