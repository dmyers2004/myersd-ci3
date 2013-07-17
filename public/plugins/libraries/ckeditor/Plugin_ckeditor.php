<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_ckeditor
{
	public $config = array();

	public function __construct() {
		include __DIR__.'/config.php';
		
		$this->config = $config;

		events::register('pre_page_build',array($this,'tohtml'));
	}

	public function tohtml() {
		get_instance()->page
			->js($this->config['js']);
	}

}

function form_wysiwyg($id='wysiwyg_editor',$options=array()) {
	$styles = ($options['style']) ? $options['style'] : array() ;

	if (count($styles) > 0) {
		$options['stylesSet'] = $id.'_styles';
	}

	$script = '<script>window.onload = function() { CKEDITOR.stylesSet.add("'.$id.'_styles", ['.implode($styles,',').']); CKEDITOR.replace("'.$id.'", '.json_encode((array)$options,JSON_UNESCAPED_SLASHES).'); };</script>';
	$element = '<textarea name="'.$id.'"></textarea>';

	return $element.$script;
}
