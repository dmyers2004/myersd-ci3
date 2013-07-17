<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
wrapper to provide path (urls) from the database settings (paths) 
and/or from the config file for matching keys

if the key isn't found the key is returned

$this->paths['admin dashboard'];

$this->paths['/admin/dashboard'] might return /admin/dashboard/google or something?

if /admin/dashboard what in the array then it would return /admin/dashboard

Requires

Settings Library

*/
class Paths implements arrayaccess
{
	private $paths = null; /* all pathss local cache */

	public function __construct() {
		$this->paths = get_instance()->load->settings('paths');
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
