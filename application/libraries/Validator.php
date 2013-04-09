<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class validator {
	
	public $validate_org;
	
	public function post($rules) {
		$CI = get_instance();

		$CI->load->library('form_validation');
		
		/* set all the rules sent in */
		$CI->form_validation->set_rules($rules);
	
		/* prep our return value */
		$rtn = array();

		/* run the validation */
		$rtn['err'] = !$CI->form_validation->run();

		/* capture a raw responds */
		$rtn['errors'] = validation_errors();

		/* capture a array responds */
		$rtn['errors_array'] = $CI->form_validation->error_array();

		/* return the error or array of errors */
		return $rtn;
	}

	public function remove_validation(&$v,$name) {		
		foreach ($v as $key => $record) {
			if ($v[$key]['field'] == $name) {
				unset($v[$key]);
				break;
			}
		}
		
		return $this;
	}
  
	
} /* end validation */