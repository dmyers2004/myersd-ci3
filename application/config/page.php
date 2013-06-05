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

/* what variable (mapped) to these get added to */
$config['preset'] = array(
	'css' => 'meta',
	'js' => 'footer',
	'meta' => 'meta'
);

/* Map Common Names to Custom View Variables */
$config['variable_mappings'] = array(
	'title' => 'meta_title', /* base site title */
	'meta' => 'page_meta', /* before <body> */
	'header' => 'page_header', /* after <body> */
	'bodyClass' => 'page_body_class', /* class attached to the <body class="#"> */
	'container' => 'container',
	'footer' => 'page_footer', /* before </body> */
	'pageBrand' => 'page_brand' /* Brand - Title */
);

/*
    ___      __             _ _   
   /   \___ / _| __ _ _   _| | |_ 
  / /\ / _ \ |_ / _` | | | | | __|
 / /_//  __/  _| (_| | |_| | | |_ 
/___,' \___|_|  \__,_|\__,_|_|\__|

*/
$config['default'] = array(
	'$template' => '_templates/default',
	'$assets' => 'assets',
	'title' => 'Apple 64',
	'pageBrand' => 'GTags',

	'meta' => '<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="/assets/fontawesome/css/font-awesome.min.css">
		<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">    
	  <script src="/assets/js/modernizr-2.6.2.min.js"></script>',

	 'header' => '<!--[if lt IE 8]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p><![endif]-->',

	 'footer' => '<script src="/assets/jquery/jquery-1.9.1.min.js"></script>
			<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
			<script src="/assets/js/plugins.js"></script>
			<script src="/assets/js/site.js"></script>'
);

/*
   ___       _     _ _     
  / _ \_   _| |__ | (_) ___ 
 / /_)/ | | | '_ \| | |/ __|
/ ___/| |_| | |_) | | | (__ 
\/     \__,_|_.__/|_|_|\___|
                            
*/
$config['public'] = array(
	'bodyClass' => '$ public',
	'foo' => 'bar',

	'logged_in' => get_instance()->auth->is_logged_in(),
	'navigation_menu' => get_instance()->menubar->render($roles,$menu),

	'meta' => '$<link rel="stylesheet" href="/assets/css/template.css">
		<link rel="stylesheet" href="/assets/css/style.css">',

	'footer' => '$<script src="/assets/admin/js/jquery.ajax.form.js"></script>
		<script src="/assets/js/onready.js"></script>'
);

/*
   _       _           _       
  /_\   __| |_ __ ___ (_)_ __  
 //_\\ / _` | '_ ` _ \| | '_ \ 
/  _  \ (_| | | | | | | | | | |
\_/ \_/\__,_|_| |_| |_|_|_| |_|
                             
*/
$config['admin'] = array(
	'$template' => 'admin/_templates/default',
	'title' => '$ - Admin',
	'crud' => &get_instance()->scaffold,
	'admin_bar' => 'navbar-inverse',
	
	'meta' => '$<link rel="stylesheet" href="/assets/css/template.css">
		<link rel="stylesheet" href="/assets/css/style.css">
		<link rel="stylesheet" href="/assets/admin/css/admin.css">
		<link rel="stylesheet" href="/assets/chosen/chosen.css">
		<link rel="stylesheet" href="/assets/table-fixed-header/table-fixed-header.css">',
		
	'footer' => '$<script src="/assets/chosen/chosen.jquery.min.js"></script>
		<script src="/assets/table-fixed-header/table-fixed-header.js"></script>
		<script src="/assets/admin/js/jquery.ajax.link.js"></script>
		<script src="/assets/admin/js/jquery.combobox.js"></script>
		<script src="/assets/admin/js/jquery.filter_input.js"></script>
		<script src="/assets/admin/js/admin_onready.js"></script>'
);

/* additional groups below */
