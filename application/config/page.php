<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Options include
 *
 * js - (Javascript) Array() merged
 * css - (Cascading Style Sheet) Array() merged
 * meta - (Meta Tags) Array() merged
 * data - key value pairs of data to add to the view $data array Array() merged
 *
 * template - template file - path based of view folder String overwritten
 * title - base template name String overwritten
 * title_separator - when additional titles are added add this between them String overwritten
 * body_class - class added to <body> element overwritten
 */

/*
we can run php here - while not "recommended" in this case I think it fits the task
also this could be directly in the function call below but I wanted to grab the separately.
if further processing was needed
*/

/*
if ($roles === null) {
	$roles = array('/nav/login');
	$menu[] = array('id'=>1,'resource'=>'/nav/login','url'=>'/auth','text'=>'Login','parent_id'=>0,'sort'=>0,'class'=>'','active'=>1);
}
*/

/*
Map Common Names to Custom View Variables you can add more

Array key is what they are called in page library
Array value is what they are referenced as in the view
*/
$config['variable_mappings'] = array(
	'title' => 'page_title', /* using in <title> */
	'header' => 'page_header', /* placed directly below <body> */
	'bclass' => 'page_body_class', /* placed in <body class=""> */
	'footer' => 'page_footer', /* placed directly above </body> in <footer></footer> tags */
	'css' => 'page_css', /* placed in <head> section */
	'meta' => 'page_meta', /* placed in <head> section */
	'js' => 'page_js', /* placed directly above </body> */
	'left_class' => 'page_lspan', /* left div class */
	'left' => 'page_left', /* holder for left column content */
	'right_class' => 'page_rspan', /* right div class */
	'right' => 'page_right', /* holder for right column content */
	'center_class' => 'page_cspan', /* center div class */
	'center' => 'container', /* holder for all center column content */
	'onready' => 'page_onready', /* on page jquery onready */
	'script' => 'page_script', /* on page between <script> tags (not onready) */
	'style' => 'page_style' /* on page between <style> tags */
);

/* these are the default settings for css <lin> and javascript <script> elements */
$config['default_css'] = array('rel'=>'stylesheet','type'=>'text/css','href'=>'');
$config['default_js'] = array('src'=>'');

/* default config */
$config['default'] = function(&$page) {
	$page
		->set('center_class','span12')
		->hide('_partials/left')
		->hide('_partials/right')
		->template('_templates/default')
		->css('/assets/vendor/flatstrap/assets/css/bootstrap.min.css')
		->css('/assets/vendor/flatstrap/assets/css/bootstrap-responsive.min.css')
		->css('/assets/vendor/fontawesome/css/font-awesome.min.css')
		->js('/assets/vendor/modernizr/modernizr-2.6.2-respond-1.1.0.min.js')
		->js('/assets/vendor/jquery/jquery-1.10.2.min.js')
		->js('/assets/vendor/flatstrap/assets/js/bootstrap.min.js');
};

$config['javascript'] = function(&$page) {
	get_instance()->load->library(array(
		'table_fixed_header/Plugin_table_fixed_header',
		'spinner/Plugin_spinner',
		'select2/Plugin_select2',
		'combobox/Plugin_combobox',
		'filter_input/Plugin_filter_input',
		'ajax_links/Plugin_ajax_links',
		'combobox/Plugin_combobox',
		'form_handler/Plugin_form_handler'
	));
};

/* public config */
$config['public'] = function(&$page) {
	$page
		->append('bclass','public admin')
		->css('/assets/public/css/template.css')
		->css('/assets/public/css/public.css')
		->css('/assets/admin/css/admin.css')
		->js('/assets/public/js/public.js')
		->js('/assets/public/js/onready.js')
		->js('/assets/admin/js/admin.js')
		->js('/assets/admin/js/onready.js')
		->func('Enum',function($input,$string,$delimiter='|') {
				$enum = explode($delimiter,$string);
				return $enum[(int) $input];
			})
		->func('Shorten',function($text,$length=64) {
				return (strlen($text) > $length) ? substr($text,0,$length).'&hellip;' : $text;
			})
		->func('Color',function($color,$with=true) {
				return (($with) ? '#' : '').trim($color,'#');
			})
		->func('CanI',function($role) {
				return get_instance()->auth->has_role_by_group($role);
		});
};

/* admin config */
$config['admin'] = function(&$page) {
};

/* add new config settings below */
