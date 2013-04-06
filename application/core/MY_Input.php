<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Input extends CI_Input
{
	/**
	* Fetch from array
	*
	* This is a helper function to retrieve values from global arrays
	*
	* @access	private
	* @param	array
	* @param	string
	* @param	bool
	* @return	string
	*
	* **Overridden to provide a default value (3rd value)
	*
	*/
	public function _fetch_from_array(&$array, $index = '', $xss_clean = FALSE)
	{
		if ( ! isset($array[$index])) {
			return $xss_clean;
		}

		if ($xss_clean === TRUE) {
			return $this->security->xss_clean($array[$index]);
		}

		return $array[$index];
	}

} /* end MY_Input */
