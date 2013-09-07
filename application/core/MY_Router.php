<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Router extends CI_Router
{

	/* patch on new handler 1st then past to parent handler */
	protected function _set_request($segments = array())
	{
		$idx = 0;

		/* is section a folder? then "this isn't the controller file we are looking for" */
		while (is_dir(APPPATH.'controllers/'.$segments[$idx]))
		{
			$idx++;
		}

		/* must be a controller file? */
		$segments[$idx++] .= 'Controller';

		/* add ajax and http method */
		$request = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
		$request = ($request == 'Get') ? '' : $request;

		$ajax = ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ? 'Ajax' : '';

		if ($request == 'Put') {
			parse_str(file_get_contents('php://input'), $_POST);
		}

		$segments[$idx] = ($segments[$idx]) ? $segments[$idx].$ajax.$request.'Action' : 'index'.$ajax.$request.'Action';

		/* call the parent */
		return parent::_set_request($segments);
	}

}