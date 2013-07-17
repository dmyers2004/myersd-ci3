<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Colorpicker
{

	public function __construct() {
		events::register('pre_page_build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->onready("$('.input-append.color').colorpicker();")
			->css('/modules/vendor/colorpicker/css/colorpicker.css')
			->js('/modules/vendor/colorpicker/js/bootstrap-colorpicker.js');
	}

}

function form_colorpicker($name='',$color='',$default='#111111',$format='hex') {
	$color = '#'.trim(($color == '') ? $default : $color,'#');

	return '<div class="input-append color" data-color="'.$color.'" data-color-format="'.$format.'">
			  <input type="text" name="'.$name.'" class="span2" value="'.$color.'">
			  <span class="add-on"><i style="background-color: '.$color.'"></i></span>
			</div>';
}
