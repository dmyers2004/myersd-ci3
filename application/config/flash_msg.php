<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['view_variable'] = 'flash_msg';
$config['pause_for_each'] = 1000; /* micro seconds */
$config['initial_pause'] = 3; /* # x  pause_for_each */
$config['js'] = '/assets/flash_msg/jquery.bootstrap.flash_msg.js';
$config['css'] = '/assets/flash_msg/flash_msg.css';

$config['methods'] = array(

	'red' => array('type'=>'error','stay'=> true),
	'blue' => array('type'=>'info'),
	'green' => array(),
	'yellow' => array('type'=>'block'),

	'error' => array('type'=>'error','stay'=> true),
	'info' => array('type'=>'info'),
	'block' => array('type'=>'block'),
	'success' => array(),

	'denied' => array('prep' => function(&$args) { $args[1] = $args[0]; $args[0] = 'Access Denied'; }, 'type'=>'error', 'stay'=>true),
	'fail' => array('prep' => function(&$args) { $args[0] = str_replace('  ',' ','Record '.$args[0].' Error'); }, 'type'=>'error', 'stay'=>true),

	'created' => array('prep' => function(&$args) { $args[0] = $args[0].' Created'; }),
	'updated' => array('prep' => function(&$args) { $args[0] = $args[0].' Updated'; }),
	'deleted' => array('prep' => function(&$args) { $args[0] = $args[0].' Deleted'; }),

);
