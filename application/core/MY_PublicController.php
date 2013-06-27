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

		$this->load->helpers(array('language','gravatar'));
		$this->load->library(array('paths','form_validation','menubar','page','flash_msg'));

		$session = get_instance()->session->all_userdata();

		$this->page
			->set('user',$session['user'])
			->load('public');
	}

} /* end MY_PublicController */
