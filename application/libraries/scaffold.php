<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scaffold {

	public $folder = 'admin/_partials/Scaffold/';

	public $defaults = array(
		'form/start'=>array('arg1'=>'','arg2'=>'id'),
		'table/body/row'=>array('arg1'=>'','arg2'=>''),
		'table/action/row'=>array(),
		'table/body/active'=>array('arg1'=>'','arg2'=>'','arg3'=>'icon-circle-blank|icon-ok-circle'),
		'table/action/delete'=>array('arg1'=>'','arg2'=>'Delete'),
		'table/action/activate'=>array('arg1'=>'','arg2'=>'','arg3'=>'Activate|Deactivate'),
		'table/body/enum'=>array('arg1'=>'','arg2'=>'','arg3'=>'activate','arg4'=>'icon-circle-blank|icon-ok-circle')
	);
	
	public function __call($name, $arguments) {
		$return = false;

		if (substr($name,0,7) == 'return_') {
			$return = true;
			$name = substr($name,7);	
		}
		
		foreach ($arguments as $k => $v) {
			$arguments['arg'.($k+1)] = $v;
			unset($arguments[$k]);
		}

		$view = str_replace('_','/',$name); /* PSR-0-ish */
		
		return get_instance()->load->view($this->folder.$view,array_merge((array)$this->defaults[$view], $arguments),$return);
	}

	/* bootstrap field direct output */
	public function field($label='',$element='',$help='') {
		$id = $this->between('id="','"',$element);
		$help = ($help) ? '<span class="help-block">'.$help.'</span>' : '';

		$type = $this->between('type="','"',$element);
		switch ($type) {
			case 'checkbox':
				$view = 'form_checkbox';
			break;
			default:
				$view = 'form_text';
		}

		$this->$view($id,$label,$element,$help);
	}

	private function between($start, $end, $string){
		$string = ' '.$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return '';
		$ini += strlen($start);   
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
	
} /* end admin_gui */

/* make built in form_input better! */
function form_text($name,$value='',$class='',$placeholder='',$extra='') {
	return '<input type="text" id="input_'.$name.'" name="'.$name.'" class="'.$class.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$extra.'>';
}
