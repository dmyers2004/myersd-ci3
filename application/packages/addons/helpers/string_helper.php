<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class string {

	static public function after($tag,$searchthis)
	{
		if (!is_bool(strpos($searchthis,$tag)))
		return substr($searchthis,strpos($searchthis,$tag)+strlen($tag));
	}
	
	static public function before($tag,$searchthis)
	{
		return substr($searchthis,0,strpos($searchthis, $tag));
	}
	
	static public function between($tag,$that,$searchthis)
	{
		return before($that,after($tag,$searchthis));
	}
	
	static public function left($s,$num)
	{
		return substr($s,0,$num);
	}
	
	static public function right($s,$num)
	{
		return substr($s,-$num);
	}
	
	static public function mid($s,$start,$length)
	{
		return substr($s,$start-1,$length);
	}
	
	static public function nthfield($string,$spliton,$number)
	{
		$number--;
		$arr = explode($spliton,$string);
		return $arr{$number};
	}
	
	static public function instr($source,$find,$startat=0)
	{
		 $x = strpos($source,$find,$startat);
		 if ($x === false) $x = 0;
		 else $x++;
		 return $x;
	}
	
	static public function shorten($text,$length)
	{
		 return (strlen($text) > $length) ? substr($text,0,$length).'&hellip;' : $text;
	}
	
	static public function enum($input,$string,$delimiter='|')
	{
		$enum = explode($delimiter,$string);
		return $enum[(int) $input];
	}
	
	static public function mergeString($string,$data=array())
	{
		$ci = get_instance();
		$ci->load->library('parser');
		return $ci->parser->parse_string($string,$data,TRUE);
	}
	
	static public function merge($file,$data=array())
	{
		$ci = get_instance();
		$ci->load->library('parser');
		return $ci->parser->parse($file,$data,TRUE);
	}
	
	static public function print_a($ary) {
		echo '<pre>';
		echo htmlentities(print_r($ary,true));
		die();
	}
	
}