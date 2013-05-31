<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
	public $_ci_cached_vars = array();

	public function settings($group=null)
	{
		$settings = array();

		if (is_string($group)) {
			$CI = get_instance();

			/* first load file based config */
			$CI->config->load($group, TRUE, TRUE);
			$file_array = $CI->config->item($group);

			/* safety check */
			$file_array = (!is_array($file_array)) ? array() : $file_array;

			/* then load database config */
			$db_array = $CI->settings->get_settings_by_group($group);

			/* safety check */
			$db_array = (!is_array($db_array)) ? array() : $db_array;

			/* then merge them (db over file) and return */
			$settings = array_merge($file_array,$db_array);
		}

		return $settings;
	}

	/* load a template (always returned) optional load into view variable */
	public function partial($view,$data=array(),$name=null)
	{
		/* always return */
		$partial = $this->view($view,$data,true);

		/*
		if name is provided then place directly into the view variable
		and return to allow chaining
		*/
		if ($name) {
			$this->_ci_cached_vars[$name] = $partial;
			return $this;
		}

		/* return the partial */
		return $partial;
	}

	public function json($data=array())
	{
		get_instance()
			->output
			->set_header('Cache-Control: no-cache, must-revalidate')
			->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT')
			->set_header('Content-Type: application/json; charset=utf=8')
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

}
