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

$menu = get_instance()->menubar->get_active();
$roles = get_instance()->auth->get_user_roles();

/* where are the assets by default */
$config['assets'] = '/assets/';

/* what view variable to attach the page partials to */
$config['variables'] = array(
	'js' => 'page_js',
	'css' => 'page_css',
	'meta' => 'page_meta',
	'title' => 'meta_title',
	'body_class' => 'page_body_class',
	'container' => 'container'
);

/* default set */
$config['default'] = array(
	'js' => array(),
	'css' => array(),
	'meta' => array(),
	'data' => array(
		'logged_in' => get_instance()->auth->is_logged_in(),
		'navigation_menu' => get_instance()->menubar->render($roles,$menu)
	),
	'template' => '_templates/default',
	'title' => 'Apple 64',
	'title_separator' => ' - ',
	'body_class' => 'default'
);

/* public group */
$config['public'] = array(
	'css' => array(
		'css/site.css',
    'css/style.css'
	),
	'js' => array(
		'js/onready.js'
	),
	'body_class' => 'public'
);

/* admin group */
$config['admin'] = array(
	'css' => array(
		'admin/css/admin.css',
		'css/site.css',
		'chosen/chosen.css',
		'table-fixed-header/table-fixed-header.css'		
	),
	'js' => array(
		'chosen/chosen.jquery.min.js',
		'table-fixed-header/table-fixed-header.js',
		'admin/js/jquery.ajax.form.js',
		'admin/js/jquery.ajax.link.js',
		'admin/js/jquery.combobox.js',
		'admin/js/jquery.filter_input.js',
		'admin/js/admin_onready.js'
	),
	'body_class' => 'admin',
	'template' => 'admin/_templates/default'
);

/* additional groups below */

/* if your not logged in so the default login */
/*
if ($roles === null) {
	$roles = array('/nav/login');
	$menu[] = array('id'=>1,'resource'=>'/nav/login','url'=>'/admin/auth','text'=>'Login','parent_id'=>0,'sort'=>0,'class'=>'','active'=>1);
}
*/
