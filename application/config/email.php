<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";

$config['protocol'] = 'debug';
$config['smtp_host'] = 'localhost';
//$config['smtp_user'] = 'codeigniter';
//$config['smtp_pass'] = 'password';

$config['mailpath'] = APPPATH.'logs';


/* End of file email.php */
/* Location: ./application/config/email.php */
