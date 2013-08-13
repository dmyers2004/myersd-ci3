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
class Paths
{
	private $paths = null; /* all pathss local cache */

	public function __construct() {
		$this->paths = get_instance()->load->settings('paths');
	}

	public function __set($name,$value) {
		$this->paths[$name] = $value;
		
		return $this;
	}
	
	public function __get($name) {
		if (array_key_exists($name,$this->paths)) {
			$url = $this->paths[$name];
		} else {
			$url = $name;
		}
	}
	
	public function redirect($name) {
		redirect($this->__get($name));
	}

} /* end path */
