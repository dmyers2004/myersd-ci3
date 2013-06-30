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

		/* setup some view low level variables */
		$route = trim($this->router->fetch_directory().$this->router->fetch_class().'/'.$this->router->fetch_method(),'/');
		data('route_raw',$route);
		
		$route = str_replace('Controller','',str_replace('Action','',$route));
		data('route',$route);

		data('route_class',str_replace('/',' ',$route));
		
		$this->session->set_userdata('history-1', $this->input->server('HTTP_REFERER'));

		data('user_data',$this->session->userdata('user'));

		/* let's make sure all output is utf-8 */
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
