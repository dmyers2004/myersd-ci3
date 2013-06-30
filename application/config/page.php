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
	'title' => 'meta_title', /* base site title */
	'meta' => 'page_meta', /* before <body> */
	'header' => 'page_header', /* after <body> */
	'bodyClass' => 'page_body_class', /* class attached to the <body class="#"> */
	'center' => 'container',
	'left' => 'page_left',
	'right' => 'page_right',
	'footer' => 'page_footer',
	'css' => 'page_css',
	'meta' => 'page_meta',
	'nav' => 'page_nav',
	'sub_nav' => 'page_sub_nav',
	'js' => 'page_js', /* before </body> */
	'pageBrand' => 'page_brand' /* Brand - Title */
);

/* default */
$config['default'] = function(&$page,&$ci) {
	
	$page
		->template('_templates/default')
		->append('bodyClass',str_replace('/',' ',$am))
		->append('title','Apple 64')
		->append('pageBrand','Sample')
		->meta(array('charset'=>'utf-8'))
		->meta(array('http-equiv'=>'X-UA-Compatible','content'=>'IE=edge,chrome=1'))
		->meta('description','')
		->meta('viewport','width=device-width, initial-scale=1')
		->css('/assets/vendor/bootstrap/css/bootstrap.min.css')
		->css('/assets/vendor/bootstrap/css/bootstrap-responsive.min.css')
		->css('/assets/vendor/fontawesome/css/font-awesome.min.css')
		->append('footer','<script>var baseurl="http://ci3.vcap.me/";</script>')
		->js('/assets/vendor/modernizr/modernizr-2.6.2.min.js')
		->js('/assets/vendor/jquery/jquery-1.10.1.min.js')
		->js('/assets/vendor/bootstrap/js/bootstrap.min.js')
		->js('/assets/public/js/site.js')
		->append('header','<!--[if lt IE 8]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p><![endif]-->');
};

$config['public'] = function(&$page,&$ci) {
	$menu = $ci->menubar->get_active();
	$roles = $ci->auth->get_user_roles();
		
	$page
		->append('bodyClass',' public')
		->set('logged_in',$ci->auth->is_logged_in())
		->set('navigation_menu',$ci->menubar->render($roles,$menu))
		->css('/assets/public/css/template.css')
		->css('/assets/public/css/style.css')
		->js('/assets/vendor/spinner/jquery.spin.min.js')
		->js('/assets/admin/js/jquery.ajax.form.js')
		->js('/assets/public/js/plugins.js')
		->js('/assets/public/js/onready.js');
};

$config['admin'] = function(&$page,&$ci) {
	$page
		->template('admin/_templates/default')
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
		->js('/assets/admin/js/onready.js');
};
