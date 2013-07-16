<?php 

function form_colorpicker($name='',$color='',$default='#111111',$format='hex') {
	$color = '#'.trim(($color == '') ? $default : $color,'#');
	
	return '<div class="input-append color" data-color="'.$color.'" data-color-format="'.$format.'">
			  <input type="text" name="'.$name.'" class="span2" value="'.$color.'">
			  <span class="add-on"><i style="background-color: '.$color.'"></i></span>
			</div>';
}
