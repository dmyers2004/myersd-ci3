<?php 

$route['admin/test/(:any)/(:any)/(:any)/(:any)'] = "module/test/$1Controller/$2Action/$3/$4";
$route['admin/test/(:any)/(:any)/(:any)'] = "module/test/$1Controller/$2Action/$3";
$route['admin/test/(:any)/(:any)'] = "module/test/$1Controller/$2Action";
$route['admin/test/(:any)'] = "module/test/$1Controller/indexAction";

$route['admin/test'] = "module/test/adminController/indexAction";

$route['admin/users/edit/(:num)'] = "module/test/adminController/editAction/$1";
$route['admin/users/delete/(:num)/([0|1])'] = "module/test/adminController/deleteAction/$1/$2";