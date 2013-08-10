<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_colorpicker
{

	public function __construct() {
		events::register('page.build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("$('.input-append.color').colorpicker();")
			->css('{plugins}colorpicker/vendor/css/colorpicker.css')
			->js('{plugins}colorpicker/vendor/js/bootstrap-colorpicker.js');
	}

}

function form_colorpicker($name='',$color='',$default='#111111',$format='hex') {
	$color = '#'.trim(($color == '') ? $default : $color,'#');

	return '<div class="input-append color" data-color="'.$color.'" data-color-format="'.$format.'">
			  <input type="text" name="'.$name.'" class="span2" value="'.$color.'">
			  <span class="add-on"><i style="background-color: '.$color.'"></i></span>
			</div>';
}
