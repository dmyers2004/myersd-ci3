<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_table_fixed_header
{

	public function __construct() {
		events::register('pre_page_build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("$('.table-fixed-header').fixedHeader();")
			->js('{plugins}table_fixed_header/vendor/table-fixed-header.min.js');
	}

}
