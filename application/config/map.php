<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['admin/setting/form'] = array(
	'id',
	'name',
	'value',
	'group',
	'type',
	'auto_load' => 'ifempty[0]',
	'module_name'
);

$config['auth/index'] = array('email','password');
$config['auth/register'] = array('username','email','password');
$config['auth/forgot'] = array('email');
$config['auth/resend_email'] = array('email');
$config['auth/reset'] = array('key','password','id');

