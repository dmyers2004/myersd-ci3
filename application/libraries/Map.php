<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Map
{
	private $CI;
	private $config;

	public function __construct()
	{
		$this->CI = get_instance();
		$this->CI->load->library('form_validation');

		$this->config = $this->CI->load->settings('map');
	}

	/* new function */
	public function run($name,&$output,&$input = null,$dieonfail=true)
	{
		$input = ($input) ? $input : $this->CI->input->post();

		$fields = $this->config[$name];
		
		if (empty($fields)) {
			log_message('debug','Map Library: '.$name.' Config Not Found');
			
			return true;
		}

		/* need to prep our fields array depending on it's format */
		$formatted_fields = array();
		
		foreach ($fields as $key => $extras) {
			if (is_integer($key)) {
				$formatted_fields[$extras] = array($extras,'');
			} else {
				if (is_array($extras)) {
					$formatted_fields[$key] = $extras;
				} else {
					$formatted_fields[$key] = array($key,$extras);
				}
			}
		}
		
		$fields = $formatted_fields;

		foreach ($fields as $field => $extras) {
			$value = $input[$field];

			$this->CI->form_validation->run_one($extras[1],$value,$dieonfail);

			$output[$extras[0]] = $value;
		}

		return $this;
	}

	/* calls validate function on model! */
	public function validate($classmethod,&$output)
	{
		if (strpos($classmethod,'::') === false) {
			$modelname = $classmethod;
			$method = 'validate';
		} else {
			list($modelname,$method) = explode('::',$classmethod);
		}

		return $this->CI->$modelname->$method($output);
	}

} /* end Form */