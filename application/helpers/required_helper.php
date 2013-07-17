<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/* This is majorly overloaded it is both a getting and setting */
function data($name=null,$value='$uNdEfInEd$',$where='#')
{
	$ci = get_instance();

	/* handle overloading */
	if ($name === null) {
		return $ci->load->_ci_cached_vars;
	}

	if ($value === '$uNdEfInEd$') {
		return $ci->load->_ci_cached_vars[$name];
	}

	if ($value !== '') {
		/* overwrite (#) is default */
		switch ($where) {
			case '<': // Prepend
				$current = $ci->load->_ci_cached_vars[$name];

				if (strpos($current, $value) !== false) {
					$value = $current;
				} else {
					$value = $value.$current;
				}
			break;
			case '>': // Append
				$current = $ci->load->_ci_cached_vars[$name];

				if (strpos($current, $value) !== false) {
					$value = $current;
				} else {
					$value = $current.$value;
				}
			break;
			case '-': // Remove
				$value = str_replace($value,'',$ci->load->_ci_cached_vars[$name]);
			break;
		}

		$ci->load->_ci_cached_vars[$name] = $value;
	}

	return $this;
}