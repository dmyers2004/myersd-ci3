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
	public $libraries = array();
	public $helpers = array();
	public $models = array();
	public $data = array();

	public $controller_model = null;

	public function __construct() {
		parent::__construct();

		if ($this->config->item('site_open') === FALSE) {
			show_error('Sorry the site is shut for now.');
		}

		$this->load->model($this->models);
		$this->load->helpers($this->helpers);
		$this->load->library($this->libraries);
	}
	
	/* make chain-able data */
	public function data($name,$value,$where='replace') {
		data($name,$value,$where);
		return $this;	
	}
	
} /* end MY_Controller */
