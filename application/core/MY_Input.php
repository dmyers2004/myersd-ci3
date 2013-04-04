<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Input extends CI_Input {

	public $filter_errors;
	public $filter;
	public $value;

	public function filter(&$value,$filter,$return=TRUE) {
		$CI = get_instance();

		$CI->load->library('form_validation');
		$CI->form_validation->reset_validation();

		$this->filter_error ='';
		$this->filter = $filer;
		$this->value = $value;

		$CI->form_validation->set_data(array('foobarvariable'=>$value));
		$CI->form_validation->set_rules('foobarvariable', 'input filter', $filter);

		$pass = $CI->form_validation->run();

		$this->filter_errors = validation_errors();

		log_message('debug',$this->filter_error);

		$CI->form_validation->reset_validation();
		unset($CI->form_validation->validation_data);
			
		if ($return == false && $pass == false) {
			show_error($value.'<br>'.$this->filter_errors.'<br>'.$filter,404,'Incorrect Input');
			die();
		}
	
		return $pass;
	}

	public function filter_errors() {
		return $this->filter_errors;
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
		if ( ! isset($array[$index]))
		{
			return $xss_clean;
		}

		if ($xss_clean === TRUE)
		{
			return $this->security->xss_clean($array[$index]);
		}

		return $array[$index];
	}

	/**
	* Capture form elements into model array
	* $array = passed by reference and modified
	* $fields = array('form element name'=>'model row name','form element name & model row name match');
	* 					 or 'field,field,field,field'
	* 					 or 'field>default,field,field'
	* $input = optional $_POST or custom input
	*
	* ## Added to map 1 array to another
	*
	*/
	public function map($fields,$input=NULL)
	{
		$mapped = array();
		
		$input = ($input) ? $input : $this->post(NULL, TRUE); /* XSS cleaned */

		$fields = (is_string($fields)) ? explode(',',$fields) : $fields;

		foreach ($fields as $key=>$value)
		{
			/**
			* if the key is a integer then they either
			* named the form element with a integer?? or
			* they want us to use the model name
			*/

			$default = null;
			
			if (strpos($value, '>') !== false) {
				$parts = explode('>',$value);
				$value = $parts[0];
				$default = $parts[1];
			}

			if (is_integer($key)) {
				$key = $value;
			}

			$mapped[$value] = (!isset($fields[$key])) ? $default : $fields[$key];
		}
		
		return $mapped;
	}

} /* end MY_Input */
