<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Input extends CI_Input
{
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
	* **Overridden to provide a default value (3rd value)
	*
	*/
	public function _fetch_from_array(&$array, $index = '', $xss_clean = FALSE)
	{
		if ( ! isset($array[$index])) {
			return $xss_clean; /* return it as a default */
		}

		if ($xss_clean === TRUE) {
			return $this->security->xss_clean($array[$index]);
		}

		return $array[$index];
	}
	
	/*
	capture form elements using a validation array adding
	dbfield (defaults to field)
	default [optional]

	returns pass (true) / fail (false)
	*/

	public function map($rules,&$output,&$input = null,$xss = true,$return=true)
	{		
		$CI = get_instance();
		$CI->load->library('form_validation');

		/* did they send in input? if not use post with xss by default */
		$input = ($input) ? $input : $this->post(NULL, $xss); /* XSS cleaned */

		/* loop through all the form validation rules with the additional map rules! */
		foreach ($rules as $r) {
			/* form field */
			$field = $r['field'];

			/* if database field not filled in use form field */
			$dbfield = ($r['dbfield']) ? $r['dbfield'] : $field;

			/* insert the default if the input field is invalid (good for checkboxes!) */
			$value = $prevalue = (isset($input[$field])) ? $input[$field] : $r['default'];

			/* run the filter on this value using return if sent in */
			$CI->form_validation->reset_validation();
			$CI->form_validation->set_data($input);
			$CI->form_validation->set_rules($r['rules']);

			/* run the validation if fail (false) return pronto */
			if ($CI->form_validation->run() === false) {
				log_message('info','MY_Input::map '.$prevalue.'/'.$value.'/'.validation_errors().'/'.$r['rules']);
				return false;
			}

			/* if not then build the output array (passed by ref) with the new value (prepping for example) */
			$output[$dbfield] = set_value($field);
		}
		
		/* return true because all validations passed */
		return true;
	}

	/*
	filter a value (passed by reference) using a form validation string
	optionally dying or returning true (pass) false (fail)
	*/

	public function filter(&$value,$filter,$return=true)
	{
		$CI = get_instance();
		$CI->load->library('form_validation');
		
		$bogus = 'foobarvariable';
		
		/* make sure it's reset - incase it's already loaded and used we need it empty */
		$CI->form_validation->reset_validation();

		/* setup a bogus array for testing - set_data before set_rule!! */
		$CI->form_validation->set_data(array($bogus=>$value));

		/* setup our rule on the bogus array key for testing using the filter sent in - bogus name "input filter" */
		$CI->form_validation->set_rules($bogus, 'input filter', $filter);

		/* run the validation and capture output */
		$pass = $CI->form_validation->run(); /* true = pass */

		/* recapture the processed variable */
		$value = set_value($bogus);

		/* log the error if any */
		if ($pass === false ) {
			log_message('info','MY_Input::filter '.$value.'/'.validation_errors().'/'.$filter);
		}

		/*
		if the validation failed AND they want to "die hard" - do it 
		This might be needed when you already validated the input or had 
		values generated by code there for you know the input should be good
		except somebody is now manually trying to send in "different" values
		*/
		if ($return === false && $pass === false) {
			show_error('FAIL: Incorrect Input',404);
			die();
		}

		/* return the pass boolean */
		return $pass;
	}
	

} /* end MY_Input */
