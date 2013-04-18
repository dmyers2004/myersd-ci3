<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function append_data($variable,$value) {
	get_instance()->load->vars(array($variable=>get_instance()->load->get_var($variable).$value));
}

function insert_data($variable,$value) {
	get_instance()->load->vars(array($variable=>$value));
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
