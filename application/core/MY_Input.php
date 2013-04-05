<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Input extends CI_Input
{
	public $filter_errors;

	public function filter(&$value,$filter,$return=true)
	{
		$CI = get_instance();

		$CI->load->library('form_validation');
		$CI->form_validation->reset_validation();

		$this->filter_error ='';

		$CI->form_validation->set_data(array('foobarvariable'=>$value));
		$CI->form_validation->set_rules('foobarvariable', 'input filter', $filter);

		$pass = $CI->form_validation->run(); /* true = pass */

		$value = $CI->form_validation->_field_data['foobarvariable']['postdata'];

		$this->filter_errors = validation_errors();

		log_message('debug',$this->filter_error);

		$CI->form_validation->reset_validation();

		if ($return == false && $pass == false) {
			//$text = $value.'<br>'.$this->filter_errors.'<br>'.$filter;
			show_error($text,404,'Incorrect Input');
			die();
		}

		return $pass;
	}

	public function filter_errors()
	{
		return $this->filter_errors;
	}

	/*
	capture form elements into database array with defaults and filters

	returns pass (true) / fail (false)
	*/

	public function map($filter,&$output,&$input=null,$xss = true,$return=true)
	{
		$input = ($input) ? $input : $this->post(NULL, $xss); /* XSS cleaned */

		foreach ($filter as $f) {
			list($dbfield,$htmlfield,$default,$filter) = explode('>',$f);

			$htmlfield = ($htmlfield) ? $htmlfield : $dbfield;
			$default = ($default) ? $default : null;
			$filter = ($filter) ? $filter : '';

			$value = (!isset($input[$htmlfield])) ? $default : $input[$htmlfield];

			if (!empty($filter)) {
				if ($this->filter($value,$filter,$return) === false) {
					return false;
				}
			}

			$output[$dbfield] = $value;
		}

		return true;
	}

	/**
	* Fetch from array
	*
	* This is a helper function to retrieve values from global arrays
	*
	* @access	private
	* @param	array
	* @param	string
	* @param	bool
	* @return	string
	*
	* ##Overridden to provide a default value (3rd value)
	*
	*/
	public function _fetch_from_array(&$array, $index = '', $xss_clean = FALSE)
	{
		if ( ! isset($array[$index])) {
			return $xss_clean;
		}

		if ($xss_clean === TRUE) {
			return $this->security->xss_clean($array[$index]);
		}

		return $array[$index];
	}

} /* end MY_Input */
