<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Input extends CI_Input
{
	/* new method */
	public function filter($name,&$input,$dieonfail=true)
	{
		$CI = get_instance();
		$CI->load->library('form_validation');

    $config = $CI->load->settings('input');

		$rule = $config[$name];

		if (empty($rule)) {
			log_message('debug','Input Filter Config Named: '.$name.' Not Found');

			return true;
		}

		return $CI->form_validation->run_one($rule,$input,$dieonfail);
	}
}