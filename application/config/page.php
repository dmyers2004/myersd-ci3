<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Options include
 *
 * js - (Javascript) Array() merged
 * css - (Cascading Style Sheet) Array() merged
 * meta - (Meta Tags) Array() merged
 *
 * template - template file - path based of view folder String overwritten
 * title - base template name String overwritten
 * title_separator - when additional titles are added add this between them String overwritten
 * data - key value pairs of data to add to the view $data array Array() merged
 *
 */

$config['variables'] = array(
	'js' => 'page_js',
	'css' => 'page_css',
	'meta' => 'page_meta',
	'title' => 'meta_title',
	'body_class' => 'page_body_class',
	'container' => 'container'
);

$config['default'] = array(
	'js' 									=> array(),
	'css'									=> array(),
	'meta'								=> array(),
	'template'						=> '_templates/default',
	'title'								=> 'Apple 64',
	'title_separator'			=> '-',
	'body_class'					=> 'default',
	'data'								=> array(
		'foo'			=> 		'bar'
	)
);

$config['public'] = array(
	'body_class' => 'public'
);

$config['admin'] = array(
	'body_class' => 'admin',
	'template' => 'admin/_templates/default'
);