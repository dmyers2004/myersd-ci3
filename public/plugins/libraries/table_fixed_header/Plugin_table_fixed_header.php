<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_table_fixed_header
{

	public function __construct() {
		events::register('page.build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->js('{plugins}table_fixed_header/javascript.js')
			->css('{plugins}table_fixed_header/style.css');
	}

}
