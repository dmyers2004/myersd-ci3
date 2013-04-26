<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* load our 2 children classes as well */
require 'MY_PublicController.php';
require 'MY_AdminController.php';

class MY_Controller extends CI_Controller
{
	public $layout = '_templates/default';

	public $window_title = 'Shelly';
	public $window_title_sep = ' - ';
	public $window_title_sub = null; /* Append to sitename */
	
	public $page_brand = 'Shell';

	public $data = array(); /* controller view storage */

	public $helpers = array();
	public $models = array();
	public $model_string = 'm%';

  public function __construct() {
    parent::__construct();

		$this->_load_models();
		$this->_load_helpers();

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

		$this->load->b4e1eb53c674ea593cfcd9df316443ff = $this->layout;
	}

  private function _load_models() {
    foreach ($this->models as $model) {
      $this->load->model($this->_model_name($model), $model);
    }
  }

  protected function _model_name($model) {
    return str_replace('%', $model, $this->model_string);
  }

  private function _load_helpers() {
    foreach ($this->helpers as $helper) {
      $this->load->helper($helper);
    }
  }
  
  public function data($variable,$value) {
	  $this->load->vars(array($variable=>$value));
  	return $this;
  }

} /* end MY_Controller */
