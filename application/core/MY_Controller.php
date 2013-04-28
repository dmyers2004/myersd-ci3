<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is the root of all controllers only 
 * add to this ONLY if you want all controllers 
 * to inherit it's methods and construct
 */

require 'MY_PublicController.php';
require 'MY_AdminController.php';

class MY_Controller extends CI_Controller
{

	public function __construct() {
		parent::__construct();

		if ($this->config->item('site_open') === FALSE) {
			show_error('Sorry the site is shut for now.');
		}
	}

} /* end MY_Controller */
