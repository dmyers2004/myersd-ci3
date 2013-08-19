<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extend Jamie Rumbelow's model
 * This will make upgrades easier
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-model
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

/* load jamie's model */
require __DIR__.'/../libraries/Jamie_model.php';

/* extend it */
class MY_Model extends Jamie_model
{

	public function __construct()
	{
		$this->validate = &$this->fields;

		parent::__construct();
  }

	public function filter($which,$input=null,$dieonfail=true) {
  	return $this->input->filter($this->fields[$which],$input,$dieonfail);
	}

	public function map($input=null,$dieonfail=true)
	{
		return $this->input->map($this->validate,$input,$dieonfail);
	}

	public function json_validate($validate=null)
	{
		$this->load->library('form_validation');

		$validate = ($validate) ? $validate : $this->validate;

		$this->form_validation->reset_validation();
		$this->form_validation->set_rules($validate);

		return $this->form_validation->run_array();
	}

}