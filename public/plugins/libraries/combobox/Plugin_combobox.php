<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_combobox
{

	public function __construct() {
		events::register('page.build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("$('.combobox').combobox();")
			->js('{plugins}combobox/jquery.combobox.js');
	}

}
