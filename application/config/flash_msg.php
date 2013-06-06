<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['view_variable'] = 'flash_msg';
$config['initial_pause'] = 4; /* seconds */
$config['pause_each_after'] = 800; /* micro seconds */
$config['js'] = '/assets/js/jquery.bootstrap.growl.js';
$config['css'] = '/assets/css/flash_msg.css';

$config['methods'] = array(

	'red' => array('prep' => null, 'type'=>'error','stay'=> true),
	'blue' => array('prep' => null, 'type'=>'info','stay'=> false),
	'green' => array('prep' => null, 'type'=>'success','stay'=> true),
	'yellow' => array('prep' => null, 'type'=>'block','stay'=> true),

	'error' => array('prep' => null, 'type'=>'error','stay'=> true),
	'info' => array('prep' => null, 'type'=>'info','stay'=> false),
	'block' => array('prep' => null, 'type'=>'block','stay'=> true),
	'success' => array('prep' => null, 'type'=>'success','stay'=> true),

	'denied' => array('prep' => function(&$args) { $args[1] = $args[0]; $args[0] = 'Access Denied'; }, 'type'=>'error','stay'=> true),
	'fail' => array('prep' => function(&$args) { str_replace('  ',' ','Record '.$args[0].' Error'); }, 'type'=>'error','stay'=> true),

	'created' => array('prep' => function(&$args) { $args[0].' Created'; }, 'type'=>'success','stay'=> false),
	'updated' => array('prep' => function(&$args) { $args[0].' Updated'; }, 'type'=>'success','stay'=> false),
	'deleted' => array('prep' => function(&$args) { $args[0].' Deleted'; }, 'type'=>'success','stay'=> false),

);
