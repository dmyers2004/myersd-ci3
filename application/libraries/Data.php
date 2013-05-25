<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* oop wrapper for CI views _ci_cached_vars */
/* to use my pages class and parser you must use this */
class data implements ArrayAccess {
	
	public function set($name, $value) {
		get_instance()->load->_ci_cached_vars[$name] = $value;		
	}

	public function &get($name) {
		return get_instance()->load->_ci_cached_vars[$name];		
	}

	public function offsetGet($offset) {
		return $this->get($offset);
	}

	public function offsetSet($offset, $value) {
		$this->set($offset, $value);
	}
	
	public function offsetExists($offset) {
		return isset(get_instance()->load->_ci_cached_vars[$offset]);
	}
	public function offsetUnset($offset) {
		unset(get_instance()->load->_ci_cached_vars[$offset] );
	}
	
} /* end class */