<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['paths'] = array(
	'login' => '/auth',
	'forgot password' => '/auth/forgot',
	'register' => '/auth/register',
	'home' => '/',
	'admin home' => '/ticket',
	'resend login email' => '/auth/resend_email',
);

$config['admin/setting/form'] = array(
	'id',
	'name',
	'value',
	'group',
	'type',
	'auto_load' => 'ifempty[0]',
	'module_name'
);

$config['admin/access/form'] = array(
	'id',
	'description',
	'resource',
	'active' => 'ifempty[0]',
	'type'
);

$config['admin/group/form'] = array(
	'id',
	'name',
	'description'
);

$config['admin/menubar/form'] = array(
	'id',
	'text',
	'resource',
	'url',
	'parent_id',
	'class',
	'active'
);

$config['admin/user/form'] = array(
	'id',
	'username',
	'email',
	'password',
	'group_id',
	'activated' => 'ifempty[0]'
);

$config['auth/index'] = array('email','password');
$config['auth/register'] = array('username','email','password');
$config['auth/forgot'] = array('email');
$config['auth/resend_email'] = array('email');
$config['auth/reset'] = array('key','password','id');
