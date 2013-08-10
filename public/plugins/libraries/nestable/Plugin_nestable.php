<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_nestable
{

	public function __construct() {
		events::register('page.build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready('plugins.nestable.init();')
			->js('{plugins}nestable/vendor/jquery.nestable.min.js')
			->js('{plugins}nestable/vendor/nestable.min.js')
			->css('{plugins}nestable/vendor/nestable.min.css');
	}

}
