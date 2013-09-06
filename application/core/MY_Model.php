<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extend Jamie Rumbelow's model
 * This will make upgrades easier
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-model
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

/* load jamie's model */
require(APPPATH.'libraries/base/Jamie_model.php');

/* extend it */
class MY_Model extends Jamie_model
{

	public function __construct()
	{
		parent::__construct();
	}
	
  /* turn off primary id on insert because it's not required (ie empty) */
  public function insert($data, $skip_validation = false)
  {
  	if (isset($this->unset_on_insert)) {
	  	unset($data[$this->unset_on_insert]);
			unset($this->validate[$this->unset_on_insert]);
  	}

  	return parent::insert($data, $skip_validation);
  }

	public function primary_exists($primary_value)
	{
		$row = $this->get($primary_value);

		return ($row) ? true : false;
	}

	public function json_validate($validate=null)
	{
		$this->load->library('form_validation');

		$validate = ($validate) ? $validate : $this->validate;

		$this->form_validation->reset_validation();
		$this->form_validation->set_rules($validate);

		return $this->form_validation->run_array();
	}

} /* end MY Model */
