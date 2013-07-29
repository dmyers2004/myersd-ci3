<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_select2
{

	public function __construct() {
		events::register('pre_page_build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("$('.select2').select2({ width: 'resolve' });")
			->js('{plugins}select2/vendor/select2.min.js')
			->css('{plugins}select2/vendor/select2.css');
	}

}
