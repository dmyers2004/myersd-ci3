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
	public $libraries = array(); /* auto load */
	public $helpers = array(); /* auto load */
	public $models = array(); /* auto load */
	public $data = array(); /* store all controller data */

	public function __construct()
	{
		parent::__construct();

		data('route',trim($this->router->fetch_directory().str_replace('Controller','',$this->router->fetch_class()).'/'.str_replace('Action','',$this->router->fetch_method()),'/'));
		
		$this->output->set_header('Content-Type: text/html; charset=utf-8');
		//$this->output->enable_profiler(TRUE);

		if ($this->config->item('site_open') === FALSE) {
			show_error('Sorry the site is not open for now.');
		}
		
		$this->load->model($this->models);
		$this->load->helpers($this->helpers);
		$this->load->library($this->libraries);
	}

} /* end MY_Controller */
