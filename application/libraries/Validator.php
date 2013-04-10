<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class validator extends MY_Model {
	
	public function post($rules) {
		$this->validate = &$rules;
		
		return parent::validate();
	}

	public function remove(&$v,$names) {		
		$this->validate = &$v;
		
		return parent::remove_validation($names);
	}  
	
} /* end validation */
