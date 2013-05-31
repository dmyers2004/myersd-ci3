<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Options include
 *
 * js - (Javascript) Array() merged
 * css - (Cascading Style Sheet) Array() merged
 * meta - (Meta Tags) Array() merged

*  * data - key value pairs of data to add to the view $data array Array() merged
 *
 * template - template file - path based of view folder String overwritten
 * title - base template name String overwritten
 * title_separator - when additional titles are added add this between them String overwritten
 * body_class - class added to <body> element overwritten
 */

$config['title.separator'] = ' - ';

/* what view variable to attach the page partials to */
$config['variables.title'] = 'meta_title'; /* base site title */
$config['variables.meta'] = 'page_meta'; /* before <body> */
$config['variables.header'] = 'page_header'; /* after <body> */
$config['variables.container'] = 'container';
$config['variables.footer'] = 'page_footer'; /* before </body> */

/* raw string input */
$config['base'] = array(
	'variables.title' => 'Apple 64',
	
	'variables.meta' => '	<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="/assets/fontawesome/css/font-awesome.min.css">
		<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">    
	  <script src="/assets/js/modernizr-2.6.2.min.js"></script>',
	
	'variables.header' => '<!--[if lt IE 8]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->',
	
	'variables.footer' => '<script src="/assets/jquery/jquery-1.9.1.min.js"></script>
		<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="/assets/js/plugins.js">
		</script><script src="/assets/js/site.js"></script>'
);

/*
we can run php here - while not "recommended" in this case I think it fits the task
also this could be directly in the function call below but I wanted to grab the separately.
if further processing was needed
*/
$menu = get_instance()->menubar->get_active();
$roles = get_instance()->auth->get_user_roles();

/*
if ($roles === null) {
	$roles = array('/nav/login');
	$menu[] = array('id'=>1,'resource'=>'/nav/login','url'=>'/admin/auth','text'=>'Login','parent_id'=>0,'sort'=>0,'class'=>'','active'=>1);
}
*/

/* default set */
$config['default']['js'] = array();
$config['default']['css'] = array();
$config['default']['meta'] = array();
$config['default']['data'] = array(
	'foo'									=> 'bar',
	'logged_in' 					=> get_instance()->auth->is_logged_in(),
	'navigation_menu' 		=> get_instance()->menubar->render($roles,$menu),
	'page_body_class'			=> 'default',
	'page_brand'					=> 'GTags'
);
$config['default']['template'] = '_templates/default';
$config['default']['assets'] = '/assets/';
$config['default']['folder'] = '';


/* public group */
$config['public']['css'] = array(
	'css/template.css',
	'css/style.css'
);
$config['public']['js'] = array(
	'js/onready.js'
);
$config['public']['data'] = array(
	'page_body_class' => 'public'
);


/* admin group */
$config['admin']['css'] = array(
	'css/template.css',
	'css/style.css',
	'admin/css/admin.css',
	'chosen/chosen.css',
	'table-fixed-header/table-fixed-header.css'
);
$config['admin']['js'] = array(
	'chosen/chosen.jquery.min.js',
	'table-fixed-header/table-fixed-header.js',
	'admin/js/jquery.ajax.form.js',
	'admin/js/jquery.ajax.link.js',
	'admin/js/jquery.combobox.js',
	'admin/js/jquery.filter_input.js',
	'admin/js/admin_onready.js'
);
$config['admin']['data'] = array(
	'page_body_class' => 'admin'
);
$config['admin']['template'] = 'admin/_templates/default';
$config['admin']['title'] = 'Admin';

/* additional groups below */
