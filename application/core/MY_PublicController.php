<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Public controllers are accessible by anyone and have a html view
 * because of this a bunch of extra helpers and libs are loaded that
 * wouldn't be needed in say ajax or something lighter
 * 
 */

class MY_PublicController extends MY_Controller
{
	
	public $layout = '_templates/default';

	public $window_title = 'Shelly';
	public $window_title_sep = ' - ';
	public $window_title_sub = null; /* Append to window_title */
	
	public $page_brand = 'Shell';

	public $data = array(); /* controller view storage */

	public $libraries = array();
	public $helpers = array();
	public $models = array();
	public $model_string = '%_model';
	
	public function __construct() {
		parent::__construct();

		if (ENVIRONMENT == 'production') {
			$this->db->save_queries = FALSE;
		}
		
		$this->_load_models();

		$this->load->helpers('language');
		$this->load->helpers($this->helpers);
		
		$this->load->library(array('events','settings','flash_msg','form_validation','menubar'));
		$this->load->library($this->libraries);

		$this->load->vars(array('body_class'=>strtolower(str_replace('/',' ',uri_string()))));
		$this->load->vars(array('logged_in'=>$this->auth->is_logged_in()));
		$this->load->vars(array('window_title'=>$this->window_title.(($this->window_title_sub) ? $this->window_title_sep.$this->window_title_sub : '')));
		$this->load->vars(array('page_brand'=>$this->page_brand));

		$menu = $this->menubar->get_active();
		$roles = $this->auth->get_user_roles();

		/* if your not logged in so the default login */
		/*
		if ($roles === null) {
			$roles = array('/nav/login');
			$menu[] = array('id'=>1,'resource'=>'/nav/login','url'=>'/admin/auth','text'=>'Login','parent_id'=>0,'sort'=>0,'class'=>'','active'=>1);
		}
		*/
		
		$this->load->vars(array('navigation_menu'=>$this->menubar->render($roles,$menu)));

		$this->load->page_base_layout = $this->layout;
	}

	private function _load_models() {
		foreach ($this->models as $model) {
			$this->load->model(str_replace('%', $model, $this->model_string), $model);
		}
	}
	
	public function data($variable,$value) {
		$this->load->vars(array($variable=>$value));
		return $this;
	}

} /* end MY_PublicController */




