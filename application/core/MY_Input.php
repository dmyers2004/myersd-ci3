<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

define('FILTERBOL','trim|required|bol2int');
define('FILTERMD5','trim|required|md5|filter_str[32]');
define('FILTERINT','trim|required|filter_int[1]');

class MY_Input extends CI_Input
{
	public function map($rules,&$output,&$input=null,$dieonfail=true) {
		$input = ($input) ? $input : $this->post();

		foreach ($rules as $rule) {
			$variable = $input[$rule['field']];

			if ($this->_processone($rule['rules'],$variable,$rule['label'],$dieonfail,$rule['field']) === false) {
				return false;
			}

			$mappedfield = ($rule['dbfield']) ? $rule['dbfield'] : $rule['field'];
			$output[$mappedfield] = $variable;
		}

		return true;
	}

	public function filter($rules,&$output,$input,$dieonfail=true) {
		if (is_string($rules)) {
			return $this->_processone($rules,$output,$input,$dieonfail);
		} else {
			$input = ($input) ? $input : $this->post();

			foreach ($rules as $rule) {
				$variable = $input[$rule['field']];
	
				if ($this->_processone($rule['filter'],$variable,$rule['label'],$dieonfail,$rule['field']) === false) {
					return false;
				}
				
				$output[$rule['field']] = $variable;
			}

			return true;
		}
	}

	private function _processarray($rules,&$output,$input,$dieonfail,$which) {
		$input = ($input) ? $input : $this->post();

		foreach ($rules as $rule) {
			$variable = $input[$rule['field']];

			if ($this->_processone($rule[$which],$variable,$rule['label'],$dieonfail,$rule['field']) === false) {
				return false;
			}
			
			$output[$rule['field']] = $variable;
		}

		return true;
	}

	private function _processone($rule,&$variable,$label,$dieonfail=true,$fieldname='FoObArPlAcEhOlDeR') {
		$CI = get_instance();
		$CI->load->library('form_validation');

		/* does this contain default? if so we need to handle this */
		if (empty($variable)) {
			$r = explode('|',$rule);
			foreach ($r as $x) {
				if (substr($x,0,7) === 'default') {
					$variable = substr($x,8,-1);
					$rule = str_replace('default[','default_dummy[',$rule);
					break;
				}
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
			log_message('debug','MY_Input::filter Value:"'.$variable.'" Errors:"'.validation_errors().'" Filter"'.$rule.'"');

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