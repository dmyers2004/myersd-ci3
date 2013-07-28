<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function is_image_file($path)
{
	if (preg_match("/(.)+\\.(jp(e){0,1}g$|gif$|png$)/i",$path))
	{
		return TRUE;
	}
	return FALSE;
}

/* End of file MY_file_helper.php */
/* Location: ./application/helpers/MY_file_helper.php */
