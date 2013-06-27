<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paths implements arrayaccess
{
	private $paths = null; /* all pathss local cache */

	public function offsetSet($offset, $value) {
		$this->init();
		
		if (is_null($offset)) {
			$this->paths[] = $value;
		} else {
			$this->paths[$offset] = $value;
		}
	}

	public function offsetExists($offset) {
		$this->init();

		return isset($this->paths[$offset]);
	}

	public function offsetUnset($offset) {
		$this->init();

		unset($this->paths[$offset]);
	}

	public function offsetGet($offset) {
		$this->init();

		return isset($this->paths[$offset]) ? $this->paths[$offset] : $offset;
	}
	
	public function init() {
		if (!$this->paths) {
			$config = get_instance()->load->settings('paths');
	    $this->paths = $config['paths'];
		}
	}

} /* end path */

/* add path "magic" redirect global function */
function path_redirect($key) {
	redirect(get_instance()->paths[$key]);
}