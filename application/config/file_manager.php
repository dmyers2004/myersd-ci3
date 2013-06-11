<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['driver'] = 'LocalFileSystem';

$config['path'] = FCPATH.'uploads';
$config['URL'] = base_url().'uploads';

$config['tmbPath'] = FCPATH.'thumbs';
$config['tmbURL'] = base_url().'thumbs';

$config['tmbSize'] = 48;
$config['tmbCrop'] = true;
$config['tmbBgColor'] = '#ffffff';

$config['uploadAllow'] = array('image/jpeg','image/jpeg','image/gif','image/png','application/pdf');
$config['uploadDeny'] = array();
$config['uploadOrder'] = array('allow', 'deny');
