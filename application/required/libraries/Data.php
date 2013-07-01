<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
this is a array wrapper for view data

$this->data['name'] = $value;

Requires

Nothing

*/

class Data implements arrayaccess
{
	public function offsetSet($offset, $value) {
		get_instance()->load->_ci_cached_vars[$offset] = $value;
	}

	public function offsetExists($offset) {
		return isset(get_instance()->load->_ci_cached_vars[$offset]);
	}

	public function offsetUnset($offset) {
		unset(get_instance()->load->_ci_cached_vars[$offset]);
	}

	public function offsetGet($offset) {
		return get_instance()->load->_ci_cached_vars[$offset];
	}

} /* end path */
