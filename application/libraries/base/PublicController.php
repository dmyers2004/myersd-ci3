<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Public controllers are accessible by anyone and have a html view
 * because of this a bunch of extra helpers and libs are loaded that
 * wouldn't be needed in say ajax or something lighter
 *
 */

class PublicController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (ENVIRONMENT !== 'production') {
			$this->db->save_queries = FALSE;
		}

		$this->load->helpers(array('language','gravatar'));
		$this->load->library(array('Menubar','Page','flash_msg/Flash_msg','Map'));

		$this->page
			->config('default')
			->config('theme')
			->config('public')
			->config('javascript');
	}

} /* end PublicController */

