<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

define('FILTERBOL','trim|required|filter_int[1]|bol2int');
define('FILTERMD5','trim|required|md5|filter_str[32]');
define('FILTERINT','trim|required|integer|filter_int[6]');
define('FILTERSTR','trim|required|alpha_numeric|filter_str[32]');

class MY_Input extends CI_Input
{	
	public function map($rules,$input=null,$dieonfail=true) {
		$CI = get_instance();
		$CI->load->library('form_validation');
		
		$input = ($input) ? $input : $this->post();
		
		foreach ($rules as $rule) {
			$variable = $input[$rule['field']];
	
			/* make sure it's reset */
			$CI->form_validation->reset_validation();
	
			/* setup a bogus array for testing - set_data before set_rule!! */
			$CI->form_validation->set_data(array($rule['field']=>$variable));
	
			/* setup our rule on the bogus array key for testing using the filter sent in - bogus name "input filter" */
			$CI->form_validation->set_rules($rule['field'], $rule['label'], $rule['rules']);
	
			/* log the error if any */
			if ($CI->form_validation->run() === false) {
				log_message('debug','MY_Input::filter Value:"'.$variable.'" Errors:"'.validation_errors().'" Filter"'.$rule.'" Field name:'.$rule['field']);
	
				if ($dieonfail) {
					$this->forged();
				}

				return false;	
			}
	
			$mapped = ($rule['dbfield']) ? $rule['dbfield'] : $rule['field']; 
			
			$output[$mapped] = set_value($rule['field']);
		}
		
		return $output;
	}

	public function filter($rule,$variable=null,$dieonfail=true) {
		$CI = get_instance();
		$CI->load->library('form_validation');

		/* make sure it's reset */
		$CI->form_validation->reset_validation();

		$variable = ($variable) ? $variable : $this->post($rule['field']);

		/* setup a bogus array for testing - set_data before set_rule!! */
		$CI->form_validation->set_data(array($rule['field']=>$variable));

		/* setup our rule on the bogus array key for testing using the filter sent in - bogus name "input filter" */
		$CI->form_validation->set_rules($rule['field'], $rule['label'], $rule['filter']);

		/* log the error if any */
		if ($CI->form_validation->run() === false) {
			log_message('debug','MY_Input::filter Value:"'.$variable.'" Errors:"'.validation_errors().'" Filter"'.$rule['filter'].'" Field name:'.$rule['field']);

			if ($dieonfail) {
				$this->forged();
			}

			return false;
		}

		/* return the pass boolean */
		return set_value($rule['field']);
	}	

	public function forged() {
		show_error('<strong>Forged Request Detected</strong> If you clicked on a link and arrived here...that is bad.',404);
		die();
	}

} /* end MY_Input */

/* does this contain ifempty? if so we need to handle this */
/*
if (empty($variable)) {
	if (preg_match('/ifempty\[(.*?)\]/',$rule, $matches)) {
		$variable = $matches[1];
	}
}
*/

