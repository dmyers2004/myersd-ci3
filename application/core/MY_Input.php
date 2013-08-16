<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

define('FILTERBOL','trim|required|filter_int[1]|bol2int');
define('FILTERMD5','trim|required|md5|filter_str[32]');
define('FILTERINT','trim|required|integer|filter_int[6]');
define('FILTERSTR','trim|required|alpha_numeric|filter_str[32]');

class MY_Input extends CI_Input
{	
	public function map($rules,&$output,&$input=null,$dieonfail=true) {
		get_instance()->load->library('form_validation');
		
		return $this->_processarray($rules,$output,$input,$dieonfail,'rules');
	}

	public function filter($rules,&$output,$input=null,$dieonfail=true) {
		get_instance()->load->library('form_validation');

		if (is_string($rules)) {
			$input = ($input) ? $input : 'Filter Field';
			return $this->_processone($rules,$output,$input,$dieonfail,$input);
		} else {
			return $this->_processarray($rules,$output,$input,$dieonfail,'filter');
		}
	}

	private function _processarray($rules,&$output,$input,$dieonfail,$which) {
		$input = ($input) ? $input : $this->post();

		foreach ($rules as $rule) {
			$variable = $input[$rule['field']];

			if ($this->_processone($rule[$which],$variable,$rule['label'],$dieonfail,$rule['field']) === false) {
				return false;
			}
			
			$mapped = ($which == 'filter') ? $rule['field'] : ($rule['dbfield']) ? $rule['dbfield'] : $rule['field']; 
			
			$output[$mapped] = $variable;
		}

		return true;
	}

	private function _processone($rule,&$variable,$label,$dieonfail,$fieldname) {
		$CI = get_instance();

		/* does this contain default? if so we need to handle this */
		if (empty($variable)) {
			if (preg_match('/default\[(.*)\]/',$rule, $matches)) {
				$variable = $matches[1];
				$rule = str_replace('default[','default_dummy[',$rule);
			}
		}

		/* make sure it's reset */
		$CI->form_validation->reset_validation();

		/* setup a bogus array for testing - set_data before set_rule!! */
		$CI->form_validation->set_data(array($fieldname=>&$variable));

		/* setup our rule on the bogus array key for testing using the filter sent in - bogus name "input filter" */
		$CI->form_validation->set_rules($fieldname, $label, $rule);

		/* run the validation and capture output fail (false) */
		$pass = $CI->form_validation->run();

		/* log the error if any */
		if ($pass === false) {
			log_message('debug','MY_Input::filter Value:"'.$variable.'" Errors:"'.validation_errors().'" Filter"'.$rule.'" Field name:'.$fieldname);

			if ($dieonfail === true) {
				$this->forged();
			}

			$variable = null;
		} else {
			/* recapture the processed variable */
			$variable = set_value($fieldname);
		}

		/* return the pass boolean */
		return $pass;
	}

	public function forged() {
		show_error('<strong>Forged Request Detected</strong> If you clicked on a link and arrived here...that is bad.',404);
		die();
	}

} /* end MY_Input */