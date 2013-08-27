<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['id'] = 'trim|required|filter_int[7]';
$config['hash'] = 'trim|required|md5|filter_str[32]';
$config['bol'] = 'trim|required|bol2int|filter_int[1]';
$config['int'] = 'trim|required|filter_int[7]';
$config['str'] = 'trim|required|alpha_dash|filter_str[128]';

$config['oneorzero'] = 'trim|required|bol2int|filter_int[1]';
$config['primaryid'] = 'trim|required|filter_int[7]';
