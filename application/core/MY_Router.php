<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Router extends CI_Router
{
	/*
	NOTE:
	The following DOESN"T work when using this
	enable_query_strings
	directory_trigger
	controller_trigger
	function_trigger
	*/
	/* patch on new handler 1st then past to parent handler */
	protected function _set_request($segments = array())
	{
		/* we will do some of the stuff parent::_set_request does but hey it will be easier for _set_request and well we need to do it here */
		$idx = 0;
		$path = '';

		/* is section a folder? then "this isn't the controller file we are looking for" */
		while (is_dir(APPPATH.'controllers/'.$path.$segments[$idx]))
		{
			$path .= $segments[$idx++].'/';
		}

		/* if is't not a folder then it must be the controller file? */
		$segments[$idx++] .= 'Controller';

		/* add ajax and http method */
		$request = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
		$request = ($request == 'Get') ? '' : $request;

		$ajax = ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ? 'Ajax' : '';

		if ($request == 'Put')
		{
			parse_str(file_get_contents('php://input'), $_POST);
		}

		/* if empty we will patch in index */
		$segments[$idx] = ($segments[$idx]) ? $segments[$idx].$ajax.$request.'Action' : 'index'.$ajax.$request.'Action';

		/* call the parent for the heavy lifting */
		return parent::_set_request($segments);
	}

}