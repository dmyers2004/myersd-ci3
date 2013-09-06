<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* this library is all about mapping 1 thing to another
map->path(); returns all current paths
map->path('name') returns url
map->path('name','/user/edit'); changes a url
map->path('name',true) maps & redirects to a url

map->form('config group',$form_vars)
map->form('config group',$form_vars,$form_input)
map->form('config group',$form_vars,$form_input,false)

*/

class Map
{
	private $CI;
	private $config;
	private $paths;
	private $forms;

	public function __construct()
	{
		$this->CI = get_instance();
		$this->CI->load->library('form_validation');

		$this->config = $this->CI->load->settings('map');

		$this->forms = $this->config['forms'];

		$db_settings = $this->CI->settings->get_settings_by_group('path');
		
		/* merge config file paths and database paths */
		$this->paths = ($db_settings === false) ? $this->config['paths'] : array_merge($this->config['paths'],$db_settings);
		
	}

	public function path($key=null,$value=null){
		/* return all */
		if ($key === null) {
			return $this->paths;
		}

		/* return 1 */
		if ($value === null || $value === true) {
			$url = empty($this->paths[$key]) ? $key : $this->config[$key];

			if ($value === true) {
				redirect($url);
			}
			
			return $url;
		}

		$this->paths[$key] = $value;

		return $this;
	}

	public function form($name,&$output,&$input = null,$dieonfail=true)
	{
		$input = ($input) ? $input : $this->CI->input->post();

		$fields = $this->forms[$name];

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

} /* end Form */