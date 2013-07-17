<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_combobox
{

	public function __construct() {
		events::register('pre_page_build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("$('.selectcombobox').selectcombobox();$('.combobox').combobox();")
			->js('/plugins/libraries/combobox/jquery.combobox.js');
	}

}
