<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scaffold
{
	public $folder;

	public $defaults = array(
		'form/start'=>array('','id'),
		'table/body/active'=>array('','','icon-circle-blank|icon-ok-circle'),
		'table/action/delete'=>array('','Delete'),
		'table/action/activate'=>array('','','Activate|Deactivate'),
		'table/body/enum'=>array('','','activate','icon-circle-blank|icon-ok-circle'),
	);

	public function __construct($folder=null)
	{
		$this->folder = ($folder) ? $folder : '_scaffold/';
	}

	public function __call($name, $arguments)
	{
		$return = false;

		if (substr($name,0,7) == 'return_') {
			$return = true;
			$name = substr($name,7);
		}

		$view = str_replace('_','/',$name); /* PSR-0-ish */

		$new_arguments = array();

		for ($i = 0; $i <= 8; $i++) {
			$default = isset($this->defaults[$view][$i]) ? $this->defaults[$view][$i] : '';
			$new_arguments['arg'.($i+1)] = isset($arguments[$i]) ? $arguments[$i] : $default;
		}

		unset($arguments);

		return get_instance()->load->view($this->folder.$view,$new_arguments,$return);
	}

} /* end Scaffold */

/* make built in form_input better! */
function form_text($name,$value='',$class='',$placeholder='',$extra='')
{
	return '<input type="text" id="input_'.$name.'" name="'.$name.'" class="'.$class.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$extra.'>';
}
