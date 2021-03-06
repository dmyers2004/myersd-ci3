<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * FUEL CMS
 * http://www.getfuelcms.com
 *
 * An open source Content Management System based on the 
 * Codeigniter framework (http://codeigniter.com)
 *
 * @package		FUEL CMS
 * @author		David McReynolds @ Daylight Studio
 * @copyright	Copyright (c) 2011, Run for Daylight LLC.
 * @license		http://www.getfuelcms.com/user_guide/general/license
 * @link		http://www.getfuelcms.com
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * FUEL Validator Helper
 *
 * Provides validation function for the Validator Library Class
 *
 * @package		FUEL CMS
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David McReynolds @ Daylight Studio
 * @link		http://www.getfuelcms.com/user_guide/helpers/validator_helper
 */


// --------------------------------------------------------------------

/**
 * Check for variable solvency
 *
 * @access	public
 * @param	mixed	variable of any kind
 * @return	boolean
 */
function required($var)
{
	$var = trim($var);
	if (!empty($var)) 
	{
		return TRUE;
	} 
	else 
	{
		return FALSE;
	}
}
   
// --------------------------------------------------------------------

/**
 * Check for matches within a string
 *
 * @access	public
 * @param	string	string containing content to be matched against
 * @param	string	regular expression (delimiters excluded)
 * @return	boolean
 */
function regex($var = null, $regex)
{
	return preg_match('#'.$regex.'#', $var);
} 

// --------------------------------------------------------------------

/**
 * Ensure at least one array variable contains content
 *
 * @access	public
 * @param	array	array containing values of indiscriminate size
 * @return	boolean
 */
function has_one_of_these($args = null)
{
	if(!is_array($args))
	{
		$args = func_get_args();
	}
	foreach($args as $val)
	{
		if(!empty($val))
		{
			return TRUE;
		}
	}
	return FALSE;
} 

// --------------------------------------------------------------------

/**
 * Validate email address against standard email address form
 *
 * @access	public
 * @param	string	string containing email address
 * @return	boolean
 */
function valid_email($email)
{
    return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
}
 
// --------------------------------------------------------------------

/**
 * Ensure a numeric value is less than given size
 *
 * @access	public
 * @param	int		interger of any length
 * @param 	int		interger of any lenth to test against 
 * @return	boolean
 */
function min_num($var, $limit = 1)
{
	if($var < $limit)
	{
		return FALSE;	
	}
	return TRUE;
}

// --------------------------------------------------------------------

/**
 * Ensure a numeric value is greater than given size
 *
 * @access	public
 * @param	int		interger of any length
 * @param 	int		interger of any lenth to test against 
 * @return	boolean
 */
function max_num($var, $limit = 1)
{
	if($var > $limit)
	{
		return FALSE;	
	}
	return TRUE;
}

// --------------------------------------------------------------------

/**
 * Ensure a numeric value exists between a given size
 *
 * @access	public
 * @param	int		interger of any length
 * @param 	int		interger of any lenth to test low
 * @param 	int		interger of any lenth to test high 
 * @return	boolean
 */
function is_between($var, $lo, $hi)
{
	if($var <= $hi AND $var >= $lo)
	{
		return TRUE;
	}
	return FALSE;
}

// --------------------------------------------------------------------

/**
 * Ensure a numeric value exists outside a given range
 *
 * @access	public
 * @param	int		interger of any length
 * @param 	int		interger of any lenth to test low
 * @param 	int		interger of any lenth to test high 
 * @return	boolean
 */
function is_outside($var, $lo, $hi)
{
	if($var >= $hi AND $var <= $lo)
	{
		return TRUE;
	}
	return FALSE;
}

// --------------------------------------------------------------------

/**
 * Ensure a string's size exists within a certain limited range
 *
 * @access	public
 * @param	string	string of any length
 * @param 	int		interger to test string length against
 * @return	boolean
 */
function length_max($str, $limit = 1000)
{
	if (strlen(strval($str)) > $limit)
	{
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}

// --------------------------------------------------------------------

/**
 * Ensure a string exists within a given limit
 *
 * @access	public
 * @param	string	string of any length
 * @param 	int		interger to test string length against
 * @return	boolean
 */
function length_min($str, $limit = 1)
{
	if (strlen(strval($str)) < $limit)
	{
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}

// --------------------------------------------------------------------

/**
 * Ensure a valid phone number
 *
 * @access	public
 * @param	string	string of any length
 * @return	boolean
 */
function valid_phone($str)
{
	$num = $str;
	$num = preg_replace("#[^0-9]#", null, $str);

	if(!is_numeric($num))
	{
		return FALSE;
	}

	if(strlen($num) < 7)
	{
		return FALSE;
	}
	
	return TRUE;
}

// --------------------------------------------------------------------

/**
 * Ensure to variables are equal
 *
 * @access	public
 * @param	mixed	mixed variable to test equality
 * @param	mixed	mixed variable to test equality
 * @return	boolean
 */
function is_equal_to($val, $val2)
{
	if($val == $val2) 
	{
		return TRUE;
	}
	
	return FALSE;
}

// --------------------------------------------------------------------

/**
 * Ensure to variables are not equal
 *
 * @access	public
 * @param	mixed	mixed variable to test equality
 * @param	mixed	mixed variable to test equality
 * @return	boolean
 */
function is_not_equal_to($val, $val2)
{
	if($val != $val2) 
	{
		return TRUE;
	}
	
	return FALSE;
}

// --------------------------------------------------------------------

/**
 * Test array to see if value exists
 *
 * @access	public
 * @param	mixed	mixed variable
 * @param	array	array to test if value exists
 * @return	boolean
 */
function is_one_of_these($val, $search_in = array())
{
	if (in_array($val, $search_in))
	{
		return TRUE;
	}
	return FALSE;
}

// --------------------------------------------------------------------

/**
 * Test array to see if value does not exist
 *
 * @access	public
 * @param	mixed	mixed variable
 * @param	array	array to test if value exists
 * @return	boolean
 */
function is_not_one_of_these($val, $searchIn = array())
{
	if(!in_array($val, $searchIn))
	{
		return TRUE;
	}
	
	return FALSE;
}

// --------------------------------------------------------------------

/**
 * Test array to see if a file is of a given type
 *
 * @access	public
 * @param	string	filename
 * @param	string	mime value of file to test
 * @return	boolean
 */
function is_of_file_type($fileName, $fileType)
{
	if($fileType == 'zip') 
	{
		$fileType = 'application/zip';
	}
	if(!empty($_FILES[$fileName]['type']))
	{
		if($_FILES[$fileName]['type'] != $fileType)
		{
			return FALSE;
		}
	}
	
	return TRUE;
}

// --------------------------------------------------------------------

/**
 * Test array to see if a file is of a given type
 *
 * @access	public
 * @param	string	filename
 * @return	boolean
 */
function valid_file_upload($file_name)
{
	if(empty($_FILES[$file_name]) OR $_FILES[$file_name]['error'] > 0)
	{
		return FALSE;
	} 
	else {
		return TRUE;
	}
}

// --------------------------------------------------------------------

/**
 * Test string for valid characters
 *
 * @access	public
 * @param	mixed	string value
 * @param	array	list of allowed characters 
 * @return	boolean
 */
function is_safe_character($val, $allowed = array('_', '-'))
{
	$newVal = str_replace($allowed, '', $val);
	if(ctype_alnum($newVal)) 
	{
		return TRUE;
	}
	
	return FALSE;
}

// --------------------------------------------------------------------

/**
 * Test date and time for proper format
 *
 * @access	public
 * @param	string	date as string value
 * @param	string	format of date to test against
 * @param	string	delimiter of date value given for testing 
 * @return	boolean
 */
function valid_date_time($date, $format = "ymd", $delimiter = "-") 
{
	return (valid_date($date, $format, $delimiter) && valid_time($date));
}

// --------------------------------------------------------------------

/**
 * Test date for proper format
 *
 * @access	public
 * @param	string	date as string value
 * @param	string	format of date to test against
 * @param	string	delimiter of date value given for testing 
 * @return	boolean
 */
function valid_date($date, $format = "ymd", $delimiter = "-") 
{
	list($d1, $d2, $d3) = sscanf($date, "%d".$delimiter."%d".$delimiter."%d");
	if($format == "ymd")
	{
		return checkdate($d2, $d3, $d1);
	}
	return checkdate($d1, $d2, $d3);
}
 
// --------------------------------------------------------------------

/**
 * Test time for proper format
 *
 * @access	public
 * @param	string	date as string value
 * @return	boolean
 */
function valid_time($date) 
{
	$date = trim($date);
	$dateArr = explode(" ", $date);
	
	if (isset($dateArr[1]))
	{
		$time = $dateArr[1];
		$timeArr = explode(":", $time);
		if (count($timeArr) == 3)
		{
			$hour = $timeArr[0];
			$min = $timeArr[1];
			$sec = $timeArr[2];
			
			if(!is_numeric($hour))
			{
				return FALSE;
			}
			if(!is_numeric($min))
			{
				return FALSE;
			}
			if(!is_numeric($sec))
			{
				return FALSE;
			}
			
			if($hour < 0 || $hour > 24)
			{
				return FALSE;
			}
			if($min < 0 || $min > 59)
			{
				return FALSE;
			}
			if($sec < 0 || $sec > 59)
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
		return TRUE;
	}
	
	return TRUE;
}

// --------------------------------------------------------------------

/**
 * Validate date passed
 *
 * @access	public
 * @param	string	month value or current date value
 * @param	string	day value
 * @param	string	year value  
 * @return	boolean
 */
function valid_mdy($m, $d = null, $y = null)
{
	if(empty($d) && empty($y))
	{
		$dateArr = explode("/", $m);
		if(count($dateArr) == 3)
		{
			$m = $dateArr[0];
			$d = $dateArr[1];
			$y = $dateArr[2];
		}
	}
	$m = (int) $m;
	$d = (int) $d;
	$y = (int) $y;
	return checkdate($m, $d, $y);
}

// --------------------------------------------------------------------

/**
 * Check to dates to ensure one is after the other
 *
 * @access	public
 * @param	string	date value as string
 * @param	string	date value as string(should be later date)
 * @return	boolean
 */
function is_after_date($date1, $date2)
{
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);
	if ($date1 < $date2) 
	{
		return FALSE;
	}
	return TRUE;
}

// --------------------------------------------------------------------

/**
 * Check to dates to ensure one is before the other
 *
 * @access	public
 * @param	string	date value as string(should be later date)
 * @param	string	date value as string
 * @return	boolean
 */
function is_before_date($date1, $date2)
{
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);
	if ($date1 > $date2) 
	{
		return FALSE;
	}
	return TRUE;
}

// --------------------------------------------------------------------

/**
 * Check to validate date exists between two others
 *
 * @access	public
 * @param	string	date value as string
 * @param	string	date value as string(low date)
 * @param	string	date value as string(high date)
 * @return	boolean
 */
function is_between_dates($val, $date1, $date2)
{
	$val = strtotime($val);
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);
	if($val > $date1 && $val < $date2) 
	{
		return TRUE;
	}
	return FALSE;
}

// --------------------------------------------------------------------

/**
 * Check to see if date is a future date
 *
 * @access	public
 * @param	string	date value as string
 * @return	boolean
 */
function is_future_date($val)
{
	return is_after_date($val, date("Y-m-d 00:00:00"));
}

// --------------------------------------------------------------------

/**
 * Check to see if date is past date
 *
 * @access	public
 * @param	string	date value as string
 * @return	boolean
 */
function is_past_date($val)
{
	return is_before_date($val, date("Y-m-d 23:59:59"));
}

// --------------------------------------------------------------------

/* End of file validator_helper.php */
/* Location: ./application/helpers/validator_helper.php */