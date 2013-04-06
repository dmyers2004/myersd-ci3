<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function append_data($variable,$value) {
	get_instance()->load->vars(array($variable=>get_instance()->load->get_var($variable).$value));
}

function insert_data($variable,$value) {
	get_instance()->load->vars(array($variable=>$value));
}

function pop_off(&$ary,$name) {
	$rtn = $ary[$name];
	unset($ary[$name]);
	return $rtn;
}