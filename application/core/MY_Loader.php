<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
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
			$settings = array_merge_recursive($file_array,$db_array);
		}

		return $settings;
	}

  public function template($view,$layout=null)
  {
    $layout = ($layout) ? $layout : $this->page_base_layout;

    /* final output */
    $this->view($layout, array('container'=>$this->view($view,$data,true)), false);
	}
	
	public function partial($view,$data=array()) {
		return $this->view($view,$data,true);
	}

	public function json($data=array())
	{
		get_instance()->output->set_content_type('application/json')->set_output(json_encode($data));
	}

}
