<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder/elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder/elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder/elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'file_manager/elfinder/elFinderVolumeLocalFileSystem.class.php';

class File_manager
{
	public $config = array();
	public $standalone = false;

	public function __construct()
	{
		$this->config = get_instance()->load->settings('file_manager');
		
		events::register('pre_build',array($this,'tohtml'));
	}

	public function standalone() {
		$this->standalone = true;
	}
	
	public function options($override = array(),$group = 'default') {
		/* you can send in standalone here as well */	
		if ($override['standalone'] == true) {
			$this->standalone = true;
		}
		unset($override['standalone']);
	
		return array_merge((array)$this->config['options_'.$group],$override);
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
  
	public function tohtml($page)
	{
		$js = ($this->standalone) ? $this->config['standalone_js'] : $this->config['js'];
		foreach ($js as $f) {
			$page->js($f);	
		}
		
		$css = ($this->standalone) ? $this->config['standalone_css'] : $this->config['css'];
		foreach ($css as $f) {
			$page->css($f);	
		}
		
		$page->append('js','<script>$(document).ready(function(){qzud
		('.(($this->standalone) ? 'true' : 'false').');})</script>');
	}
}