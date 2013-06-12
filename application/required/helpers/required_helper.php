<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * add data to the view from any where with 3 modes
 * replace (default)
 * append
 * prepend
 */
function data($name,$value,$where='replace')
{
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

function getData($name) {
	return @get_instance()->load->_ci_cached_vars[$name];
}

function after($tag,$searchthis)
{
	if (!is_bool(strpos($searchthis,$tag)))
	return substr($searchthis,strpos($searchthis,$tag)+strlen($tag));
}

function before($tag,$searchthis)
{
	return substr($searchthis,0,strpos($searchthis, $tag));
}

function between($tag,$that,$searchthis)
{
	return before($that,after($tag,$searchthis));
}

function left($s,$num)
{
	return substr($s,0,$num);
}

function right($s,$num)
{
	return substr($s,-$num);
}

function mid($s,$start,$length)
{
	return substr($s,$start-1,$length);
}

function nthfield($string,$spliton,$number)
{
	$number--;
	$arr = explode($spliton,$string);
	return $arr{$number};
}

function instr($source,$find,$startat=0)
{
	 $x = strpos($source,$find,$startat);
	 if ($x === false) $x = 0;
	 else $x++;
	 return $x;
}

function shorten($text,$length)
{
	 return (strlen($text) > $length) ? substr($text,0,$length).'&hellip;' : $text;
}

function return_enum($input,$string,$delimiter='|')
{
	$enum = explode($delimiter,$string);
	return $enum[(int) $input];
}

function enum($input,$string,$delimiter='|')
{
	$enum = explode($delimiter,$string);
	echo $enum[(int) $input];
}

function merge_string($view,$data=array())
{
	$ci = get_instance();
	$ci->load->library('parser');
	return $ci->parser->parse_string($view,$data,TRUE);
}

function merge($view,$data=array()) {
	$ci = get_instance();
	$ci->load->library('parser');
	
	return $ci->parser->parse($view,$data,TRUE);
}