<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_spinner
{

	public function __construct() {
		events::register('pre_page_build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("$('.working-img').spin({ lines: 8, length: 3, width: 4, radius: 6, speed: 1, trail: 50, hwaccel: true }).fadeOut('fast');")
			->js('/plugins/libraries/spinner/vendor/jquery.spin.min.js');
	}

}
