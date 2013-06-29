<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder/elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder/elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder/elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder/elFinderVolumeLocalFileSystem.class.php';

class File_manager
{
	public $CI;
	public $options = array();
	public $data = array('auto_resize'=>1,'bottom_footer_offset'=>0);
	public $config = array();

	public function __construct()
	{
		$this->CI = get_instance();

		$this->config = $this->CI->load->settings('file_manager');
	}

  public function process($new_config=array())
  {
    /* patch me up some $_GET */
    $qry = $_SERVER['REQUEST_URI'];
    parse_str(substr($qry, strpos($qry, '?') + 1), $_GET);

		$this->config = $this->config + $new_config;

    $connector = new elFinderConnector(new elFinder(array('roots'=>array($this->config))));
    $connector->run();
  }

  public function build()
  {
		/*
		if this is a standalone browser remove the default meta and footer stuff
		*/
		if ($this->data['standalone']) {
			$this->CI->page->clear('type','css')->clear('type','js');
		}

		foreach (explode(',',$this->config['css']) as $css) {
			$this->CI->page->css($css);	
		}

		foreach (explode(',',$this->config['js']) as $js) {
			$this->CI->page->js($js);	
		}

		$this->CI->page->append('footer',$this->getScript());
  }

  public function getScript()
  {
  	$options = json_encode($this->options,JSON_UNESCAPED_SLASHES);
		extract($this->data + array('options'=>$options));
		ob_start();
		include(dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder.js.php');
		return ob_get_clean();
	}

	public function addOption($name,$value) {
		$this->options[$name] = $value;

		return $this;
	}

	public function clearOptions() {
		$this->options = array();

		return $this;
	}

	public function addOptions($array) {
		foreach ($array as $key => $value) {
			$this->addOption($key,$value);
		}

		return $this;
	}

	public function getOptions() {
		return $this->options;
	}

	public function addData($name=NULL,$value=NULL) {
		if (is_array($name)) {
			foreach ($name as $key => $value) {
				$this->addData($key,$value);
			}
		}

		$this->data[$name] = $value;

		return $this;
	}

	public function clearData() {
		$this->data = array();

		return $this;
	}

	public function getData() {
		return $this->data;
	}

	public function addConfig($name,$value) {
		$this->config[$name] = $value;

		return $this;
	}

	public function clearConfig() {
		$this->config = array();

		return $this;
	}

	public function addConfigs($array) {
		foreach ($array as $key => $value) {
			$this->addConfig($key,$value);
		}

		return $this;
	}

	public function getConfig() {
		return $this->config;
	}

}