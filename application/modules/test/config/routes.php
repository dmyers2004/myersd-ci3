<?php 

$route['admin/test/(:any)/(:any)/(:any)/(:any)'] = "moduleController/test/$1Controller/$2Action/$3/$4";
$route['admin/test/(:any)/(:any)/(:any)'] = "moduleController/test/$1Controller/$2Action/$3";
$route['admin/test/(:any)/(:any)'] = "moduleController/test/$1Controller/$2Action";
$route['admin/test/(:any)'] = "moduleController/test/$1Controller/indexAction";

$route['admin/test'] = "moduleController/test/mainController/indexAction";
