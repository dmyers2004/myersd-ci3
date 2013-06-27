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

$config['css'] = 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css,/assets/vendor/elfinder/css/elfinder.min.css,/assets/vendor/elfinder/css/theme.css';
$config['js'] = '/assets/vendor/jquery/jquery-1.10.1.min.js,http://code.jquery.com/ui/1.10.3/jquery-ui.js,/assets/vendor/elfinder/js/elfinder.min.js';
