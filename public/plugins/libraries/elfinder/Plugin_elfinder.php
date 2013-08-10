<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once __DIR__.'/file_manager/elfinder/elFinderConnector.class.php';
include_once __DIR__.'/file_manager/elfinder/elFinder.class.php';
include_once __DIR__.'/file_manager/elfinder/elFinderVolumeDriver.class.php';
include_once __DIR__.'/file_manager/elfinder/elFinderVolumeLocalFileSystem.class.php';

class Plugin_elfinder
{
	public $config = array();
	public $standalone = false;

	public function __construct() {

		include_once __DIR__.'/config.php';

		$this->config = $config;

		events::register('page.build',array($this,'tohtml'));
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

	public function tohtml() {
		$ci = get_instance();
		
		if ($this->standalone) {
			$ci->page->clear();	
		}
		
		$ci->page
			->js('/assets/vendor/jquery/jquery-1.10.2.min.js')
			->js('/assets/vendor/jquery/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js')
			->js('/plugins/libraries/elfinder/vendor/js/elfinder.min.js')
			->css('/assets/vendor/jquery/jquery-ui-1.10.3.custom/css/smoothness/jquery-ui-1.10.3.custom.min.css')
			->css('/plugins/libraries/elfinder/vendor/css/elfinder.min.css')
			->css('/plugins/libraries/elfinder/vendor/css/theme.css')
			->onready('file_manager_init('.(($this->standalone) ? 'true' : 'false').');');
	}

}

function form_file_manager($id='file_manager',$options=array()) {
	$padding = ($options['padding']) ? $options['padding'].'px'  : '8px';

	$script = '<script>
	function file_manager_callback(pn){
		var re = new RegExp(\'(?:[\?&]|&amp;)\'+pn+\'=([^&]+)\',\'i\');
		var ma = window.location.search.match(re);
		return(ma&&ma.length>1)?ma[1]:\'\'
	};
	function file_manager_init(s){
		var o='.json_encode((array)$options,JSON_UNESCAPED_SLASHES).';
		if(s){
			o.getFileCallback=function(f){
				window.opener.CKEDITOR.tools.callFunction(file_manager_callback(\'CKEditorFuncNum\'),f.url);
				window.close();
			};
		}
		var e = jQuery("#'.$id.'").elfinder(o);
		if(s){
			e.css({top:\''.$padding.'\',left:\''.$padding.'\',right:\''.$padding.'\',bottom:\''.$padding.'\',position:\'fixed\',height:\'auto\',height:\'auto\'});
		}
	};
	</script>';
	$element = '<div id="'.$id.'"></div>';
	
	return $script.$element;
}