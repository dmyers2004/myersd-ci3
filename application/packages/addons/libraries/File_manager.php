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
		
		events::register('pre_page_build',array($this,'tohtml'));
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
  
	public function tohtml()
	{
		$ci = get_instance();
		$js = ($this->standalone) ? $this->config['standalone_js'] : $this->config['js'];
		foreach ($js as $f) {
			$ci->page->js($f);	
		}
		
		$css = ($this->standalone) ? $this->config['standalone_css'] : $this->config['css'];
		foreach ($css as $f) {
			$ci->page->css($f);	
		}
		
		$ci->page->append('js','<script>$(document).ready(function(){qzud('.(($this->standalone) ? 'true' : 'false').');})</script>');
	}
}

function form_file_manager($id='file_manager',$options=array()) {
	$padding = ($options['padding']) ? $options['padding'].'px'  : '8px';

	return '<script>
	function qyxr(pn){var re=new RegExp(\'(?:[\?&]|&amp;)\'+pn+\'=([^&]+)\',\'i\');var ma=window.location.search.match(re);return(ma&&ma.length>1)?ma[1]:\'\'};
	function qzud(s){var o='.json_encode((array)$options,JSON_UNESCAPED_SLASHES).';o.getFileCallback=function(f){window.opener.CKEDITOR.tools.callFunction(qyxr(\'CKEditorFuncNum\'),f.url);window.close();};
	var e = jQuery("#'.$id.'").elfinder(o);
	if(s){e.css({top:\''.$padding.'\',left:\''.$padding.'\',right:\''.$padding.'\',bottom:\''.$padding.'\',position:\'fixed\',height:\'auto\',height:\'auto\'});}};
	</script><div id="'.$id.'"></div>';
}