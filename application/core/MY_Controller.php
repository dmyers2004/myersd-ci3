<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* load our 2 children classes as well */
require 'MY_PublicController.php';
require 'MY_AdminController.php';

class MY_Controller extends CI_Controller
{
	public $layout = '_templates/default';

	public $title = 'Super Site';
	public $title_sep = ' - ';
	public $subtitle = null; /* Append to sitename */

	public $data = array(); /* controller view storage */

	public $helpers = array();
	public $models = array();
	public $model_string = 'm%';

  public function __construct()
  {
    parent::__construct();

		$this->_load_models();
		$this->_load_helpers();

		$this->load->vars(array('body_class'=>strtolower(str_replace('/',' ',uri_string()))));
		$this->load->vars(array('logged_in'=>$this->tank_auth->is_logged_in()));
		$this->load->vars(array('site_title'=>$this->title.(($this->subtitle) ? $this->title_sep.$this->subtitle : '')));

		$menu = $this->menubar->get_active();

		$this->load->vars(array('navigation_menu'=>$this->menubar->render(array('/*'),$menu)));

		$this->load->b4e1eb53c674ea593cfcd9df316443ff = $this->layout;
	}

  private function _load_models()
  {
    foreach ($this->models as $model) {
      $this->load->model($this->_model_name($model), $model);
    }
  }

  protected function _model_name($model)
  {
    return str_replace('%', $model, $this->model_string);
  }

  private function _load_helpers()
  {
    foreach ($this->helpers as $helper) {
      $this->load->helper($helper);
    }
  }

} /* end MY_Controller */
