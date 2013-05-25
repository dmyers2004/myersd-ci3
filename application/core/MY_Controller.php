<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is the root of all controllers 
 * add to this file ONLY if you want ALL controllers 
 * to inherit it's methods & parameters
 */

require 'MY_PublicController.php';
require 'MY_AdminController.php';

class MY_Controller extends CI_Controller
{
	public $controller_model = null;

	public function __construct() {
		parent::__construct();

		if ($this->config->item('site_open') === FALSE) {
			show_error('Sorry the site is shut for now.');
		}
	}
	
	/* chain-able wrapper for adding data */
	public function data($name,$value) {
		$this->data[$name] = $value;
		return $this;	
	}

} /* end MY_Controller */
