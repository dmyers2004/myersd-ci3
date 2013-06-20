<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wysiwyg
{

	public $CI;
	public $options = array();
	public $data = array();
	public $styles = array();
	
	public function __construct() {
		$this->CI = get_instance();	
	}

	public function build() {
		$this->CI->page
			->add('footer','$<script src="/assets/ckeditor/ckeditor.js"></script>')
			->add('footer','$'.$this->getScript());
	}

  public function getScript()
  {
  	$options = json_encode($this->options,JSON_UNESCAPED_SLASHES);
		extract($this->data + array('options'=>$options));
		ob_start();
		include(dirname(__FILE__).DIRECTORY_SEPARATOR.'wysiwyg/ckeditor.js.php');
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
	
	public function addStyle($parent=NULL,$name=NULL,$element=NULL,$style=NULL) {
		$this->styles[$parent][$name] = array($element => $style);
	}
	
}