<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Filter
{
	private $CI;
	private $config;

	public function __construct()
	{
		$this->CI = get_instance();
		$this->CI->load->library('form_validation');

    $this->config = $this->CI->load->settings('filter');
	}

	public function run($name,&$input,$dieonfail=true)
	{
		$rule = $this->config[$name];

		if (empty($rule)) {
			log_message('debug','Filter Library: '.$name.' Config Not Found');

			return true;
		}

		return $this->CI->form_validation->run_one($rule,$input,$dieonfail);
	}

} /* end Form */