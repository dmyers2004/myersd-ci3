<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Public controllers are accessible by anyone and have a html view
 * because of this a bunch of extra helpers and libs are loaded that
 * wouldn't be needed in say ajax or something lighter
 * 
 */

class MY_PublicController extends MY_Controller
{
	public $libraries = array();
	public $helpers = array();
	public $models = array();
	public $model_string = '%_model';
	
	public function __construct() {
		parent::__construct();

		if (ENVIRONMENT == 'production') {
			$this->db->save_queries = FALSE;
		}
		
		/* autoload the models */
		foreach ($this->models as $model) {
			$this->load->model(str_replace('%', $model, $this->model_string), $model);
		}

		/* autoload helpers */
		$this->load->helpers('language');
		$this->load->helpers($this->helpers);
		
		/* autoload libraries */
		$this->load->library(array('page','events','settings','flash_msg','form_validation','menubar'));
		$this->load->library($this->libraries);

		/* autoload the menubar */
		$menu = $this->menubar->get_active();
		$roles = $this->auth->get_user_roles();

		/* if your not logged in so the default login */
		/*
		if ($roles === null) {
			$roles = array('/nav/login');
			$menu[] = array('id'=>1,'resource'=>'/nav/login','url'=>'/admin/auth','text'=>'Login','parent_id'=>0,'sort'=>0,'class'=>'','active'=>1);
		}
		*/
		
		/* load our menu partial */
		$this->data('navigation_menu',$this->menubar->render($roles,$menu));
		
		/* set a logged in variable */
		$this->data('logged_in',$this->auth->is_logged_in());
	}

} /* end MY_PublicController */




