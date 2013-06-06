<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paths implements arrayaccess
{
	private $paths = array(); /* all pathss local cache */

	public function __construct() {
		get_instance()->config->load('paths', TRUE);
		$this->paths = get_instance()->config->item('paths','paths');
	}

	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->paths[] = $value;
		} else {
			$this->paths[$offset] = $value;
		}
	}
	
	public function offsetExists($offset) {
		return isset($this->paths[$offset]);
	}
	
	public function offsetUnset($offset) {
		unset($this->paths[$offset]);
	}
	
	public function offsetGet($offset) {
		return isset($this->paths[$offset]) ? $this->paths[$offset] : $offset;
	}
		
} /* end path */
