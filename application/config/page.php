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
	'title' => 'page_title',
	'header' => 'page_header',
	'bclass' => 'page_body_class',
	'footer' => 'page_footer',
	'css' => 'page_css',
	'meta' => 'page_meta',
	'js' => 'page_js',
	'nav' => 'page_nav',
	'lspan' => 'page_lspan',
	'left' => 'page_left',
	'rspan' => 'page_rspan',
	'right' => 'page_right',
	'cspan' => 'page_cspan',
	'center' => 'container'
);

/* default */
$config['default'] = function(&$page) {
	$page
		->set('lspan',0)
		->set('cspan',12)
		->set('rspan',0)
		->hide('_partials/left')
		->hide('_partials/right')
		->template('_templates/default')
		->css('/assets/vendor/bootstrap/css/bootstrap.min.css')
		->css('/assets/vendor/bootstrap/css/bootstrap-responsive.min.css')
		->css('/assets/vendor/fontawesome/css/font-awesome.min.css')
		->js('/assets/vendor/modernizr/modernizr-2.6.2.min.js')
		->js('/assets/vendor/jquery/jquery-1.10.1.min.js')
		->js('/assets/vendor/bootstrap/js/bootstrap.min.js');
};

$config['public'] = function(&$page) {
	$page
		->append('bclass','public')
		->css('/assets/public/css/template.css')
		->css('/assets/public/css/public.css')
		->js('/assets/vendor/spinner/jquery.spin.min.js')
		->js('/assets/admin/js/jquery.ajax.form.js')
		->js('/assets/public/js/plugins.js')
		->js('/assets/public/js/public.js')
		->js('/assets/public/js/onready.js');
};

$config['admin'] = function(&$page) {
	$page
		->append('title',' - Admin')
		->set('admin_bar','navbar-inverse')
		->css('/assets/admin/css/admin.css')
		->css('/assets/vendor/chosen/chosen.min.css')
		->css('/assets/vendor/table-fixed-header/table-fixed-header.min.css')
		->js('/assets/vendor/chosen/chosen.jquery.min.js')
		->js('/assets/vendor/table-fixed-header/table-fixed-header.min.js')
		->js('/assets/admin/js/jquery.ajax.link.js')
		->js('/assets/admin/js/jquery.combobox.js')
		->js('/assets/admin/js/jquery.filter_input.js')
		->js('/assets/admin/js/admin.js')
		->js('/assets/admin/js/onready.js');
};
