<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Router extends CI_Router
{
	/**
	 *  Parse Routes
	 *
	 * This function matches any routes that may exist in
	 * the config/routes.php file against the URI to
	 * determine if the class/method need to be remapped.
	 *
	 * ## auto add on request and is ajax so controller _remap isn't needed
	 *
	 * @access	private
	 * @return	void
	 */
	public function _parse_routes()
	{
		// Turn the segment array into a URI string
		$uri = implode('/', $this->uri->segments);

		// Is there a literal match?  If so we're done
		if (isset($this->routes[$uri])) {
			return $this->_set_request(explode('/', $this->routes[$uri]));
		}

		// Loop through the route array looking for wild-cards
		foreach ($this->routes as $key => $val) {
			// Convert wild-cards to RegEx
			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri)) {
				// Do we have a back-reference?
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE) {
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}

				/* start my custom code */
		 		$request = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
				$request = ($request == 'Get') ? '' : $request;

				if ($request == 'Put') {
					parse_str(file_get_contents('php://input'), $_POST);
				}

		    $val = str_replace('SUFFIX',$request.'Action',$val);
				/* end my custom code */

				return $this->_set_request(explode('/', $val));
			}
		}
		// If we got this far it means we didn't encounter a
		// matching route so we'll set the site default route
		$this->_set_request($this->uri->segments);
	}

}
