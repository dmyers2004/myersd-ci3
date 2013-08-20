<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['filter.id'] = 'trim|required|filter_int[7]';
$config['filter.hash'] = 'trim|required|md5|filter_str[32]';
$config['filter.bol'] = 'trim|required|bol2int|filter_int[1]';
$config['filter.int'] = 'trim|required|filter_int[7]';
$config['filter.str'] = 'trim|required|alpha_dash|filter_str[128]';

$config['map.admin/setting'] = array(
	'id'=> array(),
	'name'=> array(),
	'value'=> array(),
	'group'=> array(),
	'type'=> array(),
	'auto_load'=> array(),
	'module_name'=> array()
);
