<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

define('FILTERBOL','trim|required|bol2int|filter_int[1]');
define('FILTERMD5','trim|required|md5|filter_str[32]');
define('FILTERINT','trim|required|filter_int[7]');
define('FILTERSTR','trim|required|alpha_dash|filter_str[128]');

class MY_Input extends CI_Input
{

	/* new function */
	public function map($rules,&$output,&$input = null)
	{
		$CI = get_instance();
		$CI->load->library('form_validation');

		/* reset */
		$CI->form_validation->reset_validation();

		/* did they send in input? */
		$input = ($input) ? $input : $this->post();

		/* set any default values */
		foreach ($rules as $rule) {
			if (empty($input[$rule['field']])) {
				if (preg_match('/ifempty\[(.*?)\]/',$rule['rules'], $matches)) {
					$input[$rule['field']] = $matches[1];
				}
			}
		}

		$CI->form_validation->set_data($input);
		$CI->form_validation->set_rules($rules);

		/* run the validation if fail (false) return pronto */
		if ($CI->form_validation->run() === false) {
			log_message('debug','MY_Input::map Field: '.validation_errors());

			/* fail don't use it! so let's empty it */
			$output = array();

			return false;
		}

		/* populate the output */
		foreach ($rules as $rule) {
			/* if database field not filled in use form field */
			$dbfield = ($rule['dbfield']) ? $rule['dbfield'] : $rule['field'];

			/* if not then build the output array (passed by ref) with the new value (prepping for example) */
			$output[$dbfield] = set_value($rule['field']);
		}

		/* return true because all validations passed */
		return true;
	}

	/*
	filter a value (passed by reference) using a form validation string
	optionally dying or returning true (pass) false (fail)
	*/

	/* new function */
	public function filter($rule,&$value,$return=false)
	{
		$CI = get_instance();
		$CI->load->library('form_validation');

		$bogus = 'FoObArPlAcEhOlDeR';

		/* make sure it's reset - incase it's already loaded and used we need it empty */
		$CI->form_validation->reset_validation();

		/* setup a bogus array for testing - set_data before set_rule!! */
		$CI->form_validation->set_data(array($bogus=>$value));

		/* setup our rule on the bogus array key for testing using the filter sent in - bogus name "input filter" */
		$CI->form_validation->set_rules($bogus, 'input filter', $rule);

		/* run the validation and capture output fail (false) */
		$pass = $CI->form_validation->run();

		/* recapture the processed variable */
		$value = set_value($bogus);

		/* log the error if any */
		if ($pass === false) {
			log_message('debug','MY_Input::filter Value:"'.$value.'" Errors:"'.validation_errors().'" Filter"'.$rule.'"');

			if ($return === false) {
				$this->forged();
			}
		}

		/* return the pass boolean */
		return $pass;
	}

	public function forged() {
		show_error('<strong>Forged Request Detected</strong> If you clicked on a link and arrived here...that is bad.',404);
		die();
	}

} /* end MY_Input */