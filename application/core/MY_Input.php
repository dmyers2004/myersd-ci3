<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

define('FILTERBOL','trim|required|bol2int');
define('FILTERMD5','trim|required|md5|filter_str[32]');
define('FILTERINT','trim|required|filter_int[1]');

class MY_Input extends CI_Input
{
	/* fetch from array with default and optional xss clean (ON by default) */
	/* override function */
	public function fetch_from_array(&$array, $index = '', $default = '', $xss_clean = TRUE)
	{
		$value = $this->_fetch_from_array($array, $index, $xss_clean);
		return (isset($value)) ? $value : $default;
	}

	/*
	capture form elements using a validation array adding
	dbfield (defaults to field)
	default [optional]

	returns pass (true) / fail (false)
	*/

	/* new function */
	public function map($rules,&$output,&$input = null)
	{
		/* did they send in input? */
		$input = ($input) ? $input : $this->post();

		/* loop through all the form validation rules with the additional map rules! */
		foreach ((array)$rules as $rule) {

			if (!$this->filter($rule['rules'],$input[$rule['field']],true,$rule['default'],$rule['label'])) {
				return false;
			}
			
			/* if dbfield not set use field */
			$mappedfield = ($rule['dbfield']) ? $rule['dbfield'] : $rule['field'];

			/* if not then build the output array (passed by ref) with the new value (prepping for example) */
			$output[$mappedfield] = $input[$rule['field']];
		}

		/* return true because all validations passed */
		return true;
	}

	/*
	filter a value (passed by reference) using a form validation string
	optionally dying or returning true (pass) false (fail)
	*/

	/* new function */
	public function filter($rule,&$value,$return=true,$default=null,$label = 'input filter')
	{
		$CI = get_instance();
		$CI->load->library('form_validation');

		$bogus = 'FoObArPlAcEhOlDeR';

		/* make sure it's reset - incase it's already loaded and used we need it empty */
		$CI->form_validation->reset_validation();

		/* setup a bogus array for testing - set_data before set_rule!! */
		$CI->form_validation->set_data(array($bogus=>$value));

		/* setup our rule on the bogus array key for testing using the filter sent in - bogus name "input filter" */
		$CI->form_validation->set_rules($bogus, $label, $rule);

		/* run the validation and capture output fail (false) */
		$pass = $CI->form_validation->run();

		/* recapture the processed variable */
		$value = set_value($bogus,$default);

		/* log the error if any */
		if ($pass === false) {
			log_message('debug','MY_Input::filter Value:"'.$value.'" Errors:"'.validation_errors().'" Filter"'.$rule.'"');
		}

		/*
		if the validation failed AND they want to "die hard" - do it
		This might be needed when you already validated the input or had
		values generated by code there for you know the input should be good
		except somebody is now manually trying to send in "different" values
		*/
		if ($return === false && $pass === false) {
			$this->forged();
		}

		/* return the pass boolean */
		return $pass;
	}
	
	public function forged() {
		show_error('<strong>Forged Request Detected</strong> If you clicked on a link and arrived here...that is bad.',404);
		die();
	}

} /* end MY_Input */