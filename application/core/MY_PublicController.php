<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Public controllers are accessible by anyone and have a html view
 * because of this a bunch of extra helpers and libs are loaded that
 * wouldn't be needed in say ajax or something lighter
 *
 */

class MY_PublicController extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (ENVIRONMENT !== 'production') {
			$this->db->save_queries = FALSE;
		}

		$this->load->helpers('language');
		$this->load->library(array('paths','events','settings','flash_msg','form_validation','menubar','page'));

		$this->page->data('is_logged_in_as',$this->auth->get_username())->add('public');
	}

} /* end MY_PublicController */
