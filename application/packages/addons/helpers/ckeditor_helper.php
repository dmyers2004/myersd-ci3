<?php

function form_wysiwyg($id='wysiwyg_editor',$options=array()) {
	$styles = ($options['style']) ? $options['style'] : array() ;

	if (count($styles) > 0) {
		$options['stylesSet'] = $id.'_styles';
	}

	return '<textarea name="'.$id.'"></textarea><script src="'.$options['js'].'"></script><script>window.onload = function() { CKEDITOR.stylesSet.add("'.$id.'_styles", ['.implode($styles,',').']); CKEDITOR.replace("'.$id.'", '.json_encode((array)$options,JSON_UNESCAPED_SLASHES).'); };</script>';
}

