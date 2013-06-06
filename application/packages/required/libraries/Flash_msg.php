<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flash_msg
{
	private $CI = null;

	public $js = '/assets/js/jquery.bootstrap.growl.js';
	public $css = '/assets/css/flash_msg.css';

  public $messages = array();
  public $type = array(
    'red'=>'error',
    'blue'=>'info',
    'yellow'=>'block',
    'green'=>'success',
    'error'=>'error',
    'info'=>'info',
    'block'=>'block',
    'success'=>'success'
  );
  
  /* required in config */
  public $methods;
  public $view_variable;
  public $initial_pause;
  public $pause_each_after;

	public function __construct()
	{
		$this->CI = get_instance();
		$this->CI->config->load('flash_msg', TRUE);
		$this->methods = $this->CI->config->item('methods','flash_msg');
		$this->initial_pause = $this->CI->config->item('initial_pause','flash_msg');
		$this->view_variable = $this->CI->config->item('view_variable','flash_msg');
		$this->pause_each_after = $this->CI->config->item('pause_each_after','flash_msg');
		
		$this->tohtml();
	}

	public function __call($name, $arguments) {
		/* redirect */
		$arguments[1] = ($arguments[1]) ? $arguments[1] : NULL;
		
		/* get the closure */
		$func = $this->methods[$name]['prep'];
		
		/* run it if it's not null */
		if ($func) {
			$func($arguments);
		}
		
		/* send everything else in */
		return $this->add($arguments[0],$this->methods[$name]['type'],$this->methods[$name]['stay'],$arguments[1]);
	}

  /* most basic add function */
  public function add($msg='',$type='yellow',$sticky=FALSE,$redirect=null)
  {
  	$this->messages[] = array('msg'=>$msg,'type'=>$this->type[$type],'sticky'=>$sticky);
    $this->CI->session->set_flashdata('growl_flash_message_storage',$this->messages);

		if ($redirect) {
			$this->redirect($redirect);
		}

		$this->tohtml();

		return $this;
  }

	public function tohtml($variable = null,$return = false)
	{
		$variable = ($variable) ? $variable : $this->view_variable;
		
		$html = '<script src="'.$this->js.'" type="text/javascript"></script><link rel="stylesheet" href="'.$this->css.'">';

    $messages = $this->CI->session->flashdata('growl_flash_message_storage');

    if (is_array($messages)) {
    	$html .= '<script>$(document).ready(function(){';
    	foreach ($messages as $key => $msg) {
    	  $staytime = ($msg['sticky'] == TRUE) ? '' : ', stayTime: '.($this->pause_each_after * $this->initial_pause++);
    		$html .= 'jQuery.noticeAdd({ text: \''.$msg['msg'].'\', stay: \''.$msg['sticky'].'\', type: \''.$msg['type'].'\''.$staytime.' });';
    	}
    	$html .= '})</script>';
    }

		if (!$return) {
			$this->CI->load->vars(array($variable=>$html));
		}

		return $html;
	}

	public function redirect($url)
	{
  	redirect($this->CI->paths[$url]);
	}

}