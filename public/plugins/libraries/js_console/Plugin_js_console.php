<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_js_console{

	public function __construct() {
		events::register('pre_page_build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->js('/plugins/libraries/js_console/console.js');
	}

}
