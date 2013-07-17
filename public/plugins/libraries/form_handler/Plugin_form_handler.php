<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_form_handler
{

	public function __construct() {
		events::register('pre_page_build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("$('form[data-validate=true]').ajaxForm();")
			->js('{plugins}form_handler/jquery.ajax.form.js');
	}

}
