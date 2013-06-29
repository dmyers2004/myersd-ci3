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

$config['options_default'] = array(
	'url' => '/fileManagerHandler/process/'
);

$config['standalone_js'] = array(
	'/assets/vendor/jquery/jquery-1.10.1.min.js',
	'/assets/vendor/jquery/jquery-ui-1.10.3.custom.min.js',
	'/assets/vendor/elfinder/js/elfinder.min.js'
);

$config['standalone_css'] = array(
	'/assets/vendor/jquery/smoothness/jquery-ui-1.10.3.custom.min.css',
	'/assets/vendor/elfinder/css/elfinder.min.css',
	'/assets/vendor/elfinder/css/theme.css'
);

$config['js'] = array(
	'/assets/vendor/jquery/jquery-ui-1.10.3.custom.min.js',
	'/assets/vendor/elfinder/js/elfinder.min.js'
);

$config['css'] = array(
	'/assets/vendor/jquery/smoothness/jquery-ui-1.10.3.custom.min.css',
	'/assets/vendor/elfinder/css/elfinder.min.css',
	'/assets/vendor/elfinder/css/theme.css'
);
