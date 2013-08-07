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
	/* override function - as marked */
	protected function _parse_routes()
	{
		// Turn the segment array into a URI string
		$uri = implode('/', $this->uri->segments);

		// Is there a literal match?  If so we're done
		if (isset($this->routes[$uri]) && is_string($this->routes[$uri]))
		{
			return $this->_set_request(explode('/', $this->routes[$uri]));
		}

		// Loop through the route array looking for wildcards
		foreach ($this->routes as $key => $val)
		{
			// Convert wildcards to RegEx
			$key = str_replace(array(':any', ':num'), array('[^/]+', '[0-9]+'), $key);

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri, $matches))
			{
				// Are we using callbacks to process back-references?
				if ( ! is_string($val) && is_callable($val))
				{
					// Remove the original string from the matches array.
					array_shift($matches);

					// Get the match count.
					$match_count = count($matches);

					// Determine how many parameters the callback has.
					$reflection = new ReflectionFunction($val);
					$param_count = $reflection->getNumberOfParameters();

					// Are there more parameters than matches?
					if ($param_count > $match_count)
					{
						// Any params without matches will be set to an empty string.
						$matches = array_merge($matches, array_fill($match_count, $param_count - $match_count, ''));

						$match_count = $param_count;
					}

					// Get the parameters so we can use their default values.
					$params = $reflection->getParameters();

					for ($m = 0; $m < $match_count; $m++)
					{
						// Is the match empty and does a default value exist?
						if (empty($matches[$m]) && $params[$m]->isDefaultValueAvailable())
						{
							// Substitute the empty match for the default value.
							$matches[$m] = $params[$m]->getDefaultValue();
						}
					}

					// Execute the callback using the values in matches as its parameters.
					$val = call_user_func_array($val, $matches);
				}
				// Are we using the default routing method for back-references?
				elseif (strpos($val, '$') !== FALSE && strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}

				/* --- start my custom code --- */
		 		$request = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
				$request = ($request == 'Get') ? '' : $request;

				$ajax = ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ? 'Ajax' : '';

				if ($request == 'Put') {
					parse_str(file_get_contents('php://input'), $_POST);
				}

		    $val = str_replace('Action',$ajax.$request.'Action',$val);
				/* --- end my custom code --- */

				return $this->_set_request(explode('/', $val));
			}
		}

		// If we got this far it means we didn't encounter a
		// matching route so we'll set the site default route
		$this->_set_request($this->uri->segments);
	}

}
