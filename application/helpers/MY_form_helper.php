<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/* make built in form_input better! */
function form_text($name,$value='',$class='',$placeholder='',$extra='')
{
	return '<input type="text" id="input_'.$name.'" name="'.$name.'" class="'.$class.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$extra.">\n";
}

function form_textarea($name = '', $value = '', $extra = '')
{
	return '<textarea name="'.$name.'" '.$extra.'>'.form_prep($value, TRUE)."</textarea>\n";
}

function form_wysiwyg($id='wysiwyg_editor',$options=array()) {
	$styles = ($options['style']) ? $options['style'] : array() ;
	
	if (count($styles) > 0) {
		$options['stylesSet'] = $id.'_styles';
	}
	
	return '<textarea name="'.$id.'"></textarea><script src="'.$options['js'].'"></script><script>window.onload = function() { CKEDITOR.stylesSet.add("'.$id.'_styles", ['.implode($styles,',').']); CKEDITOR.replace("'.$id.'", '.json_encode((array)$options,JSON_UNESCAPED_SLASHES).'); };</script>';
}
