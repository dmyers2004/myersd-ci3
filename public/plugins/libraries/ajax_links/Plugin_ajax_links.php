<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_ajax_links
{

	public function __construct() {
		events::register('page.build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("plugins.delete_handler.init();plugins.enum_handler.init();")
			->js('{plugins}ajax_links/jquery.ajax.link.js');
	}

}
