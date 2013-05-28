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

/* where are the assets by default */
$config['assets'] = '/assets/';
$config['title'] = 'Apple 64';
$config['title_separator'] = ' - ';

/* what view variable to attach the page partials to */
$config['variables.header'] = 'page_header';
$config['variables.title'] = 'meta_title';
$config['variables.container'] = 'container';
$config['variables.footer'] = 'page_footer';

$menu = get_instance()->menubar->get_active();
$roles = get_instance()->auth->get_user_roles();

/* default set */
$config['default']['js'] = array();
$config['default']['css'] = array();
$config['default']['meta'] = array();
$config['default']['data'] = array(
	'foo'							=> 'bar',
	'logged_in' 			=> get_instance()->auth->is_logged_in(),
	'navigation_menu' => get_instance()->menubar->render($roles,$menu),
	'page_body_class'			=> 'default',
	'page_brand'					=> 'GTags'
);
$config['default']['template'] = '_templates/default';

/* public group */
$config['public']['css'] = array(
	'css/template.css',
	'css/style.css'
);
$config['public']['js'] = array(
	'js/onready.js'
);
$config['public']['data'] = array(
	'page_body_class'			=> 'public'
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
	'page_body_class'			=> 'admin'
);
$config['admin']['template'] = 'admin/_templates/default';

/* additional groups below */

/* if your not logged in so the default login */
/*
if ($roles === null) {
	$roles = array('/nav/login');
	$menu[] = array('id'=>1,'resource'=>'/nav/login','url'=>'/admin/auth','text'=>'Login','parent_id'=>0,'sort'=>0,'class'=>'','active'=>1);
}
*/
