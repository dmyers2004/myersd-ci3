<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * add data to the view from any where with 3 modes
 * replace (default)
 * append
 * prepend
 */
function data($name,$value,$where='replace') {
	switch ($where) {
		case 'prepend':
			$value = $value.get_instance()->load->_ci_cached_vars[$name];
		break;
		case 'append':
			$value = get_instance()->load->_ci_cached_vars[$name].$value;
		break;
	}

	get_instance()->load->_ci_cached_vars[$name] = $value;
}

function after($tag,$searchthis) {
	if (!is_bool(strpos($searchthis,$tag)))
	return substr($searchthis,strpos($searchthis,$tag)+strlen($tag));
}

function before($tag,$searchthis) {
	return substr($searchthis,0,strpos($searchthis, $tag));
}

function between($tag,$that,$searchthis) {
	return before($that,after($tag,$searchthis));
}

function left($s,$num) {
	return substr($s,0,$num);
}

function right($s,$num) {
	return substr($s,-$num);
}

function mid($s,$start,$length) {
	return substr($s,$start-1,$length);
}

function nthfield($string,$spliton,$number) {
	$number--;
	$arr = explode($spliton,$string);
	return $arr{$number};
}

function instr($source,$find,$startat=0) {
	 $x = strpos($source,$find,$startat);
	 if ($x === false) $x = 0;
	 else $x++;
	 return $x;
}

function shorten($text,$length) {
	 if (strlen($text) > $length) return substr($text,0,$length).'...';
	 return $text;
}

function enum($input,$string) {
	$enum = explode('|',$string);
	echo $enum[(int)$input];
}