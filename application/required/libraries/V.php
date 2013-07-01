<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
View available static functions v::method

Requires

Nothing

*/
class V
{

	static public function enum($input,$string,$delimiter='|')
	{
		$enum = explode($delimiter,$string);
		return $enum[(int) $input];
	}

	static public function shorten($text,$length=64)
	{
		 return (strlen($text) > $length) ? substr($text,0,$length).'&hellip;' : $text;
	}

}