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

	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);

		if ($this->config->item('site_open') === FALSE) {
			show_error('Sorry the site is not open for now.');
		}
		
		$this->load->model($this->models);
		$this->load->helpers($this->helpers);
		$this->load->library($this->libraries);
	}

} /* end MY_Controller */
