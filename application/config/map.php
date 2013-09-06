<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['paths'] = array(
	'login' => '/auth',
	'forgot password' => '/auth/forgot',
	'register' => '/auth/register',
	'home' => '/',
	'admin home' => '/ticket',
	'resend login email' => '/auth/resend_email',
);

$config['forms'] = array(
	'admin/setting/form' => array(
		'id',
		'name',
		'value',
		'group',
		'type',
		'auto_load' => 'ifempty[0]',
		'module_name'
	),
	
	'admin/access/form' => array(
		'id',
		'description',
		'resource',
		'active' => 'ifempty[0]',
		'type'
	),
	
	'admin/group/form' => array(
		'id',
		'name',
		'description'
	),
	
	'admin/menubar/form' => array(
		'id',
		'text',
		'resource',
		'url',
		'parent_id',
		'class',
		'active' => 'ifempty[0]'
	),
	
	'admin/user/form' => array(
		'id',
		'username',
		'email',
		'password',
		'group_id',
		'activated' => 'ifempty[0]'
	),
	
	'auth/index' => array('email','password'),
	'auth/register' => array('username','email','password'),
	'auth/forgot' => array('email'),
	'auth/resend_email' => array('email'),
	'auth/reset' => array('key','password','id')
);
