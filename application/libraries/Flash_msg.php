<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flash_msg {
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
  public $staytime = 9; /* setup the initial pause time seconds */

	public function __construct() {
		/* drivers load late therefore load it here */
		get_instance()->load->driver('session');
	
		$this->tohtml();
	}

  /* wrapper functions for add */
  public function __call($method, $param) {
    if (array_key_exists($method,$this->type)) {
      $sticky_default = ($method == 'red' || $method == 'error') ? TRUE : FALSE;
      call_user_func_array(array($this,'add'), array(@$param[0],$method,$sticky_default));
    }

    if (@$param[1]) {
    	$this->redirect($param[1]);
    }

		return $this;
  }

  /* most basic add function */
  public function add($msg='',$type='yellow',$sticky=FALSE) {
  	$this->messages[] = array('msg'=>$msg,'type'=>$this->type[$type],'sticky'=>$sticky);
    $this->session->set_flashdata('flashMessages',$this->messages);
    
		$this->tohtml();
		
		return $this;
  }

	public function tohtml($variable = 'flash_msg',$return = false) {
		$html  = '<script src="'.$this->js.'" type="text/javascript"></script>';
		$html .= '<link rel="stylesheet" href="'.$this->css.'">';
    
    $msgs = $this->session->flashdata('flashMessages');

    if (is_array($msgs)) {
    	$html .= '<script>$(document).ready(function(){';
    	foreach ($msgs as $key => $msg) {
    	  $staytime = ($msg['sticky'] == TRUE) ? '' : ', stayTime: '.(800 * $this->staytime++);
    		$html .= 'jQuery.noticeAdd({ text: \''.$msg['msg'].'\', stay: \''.$msg['sticky'].'\', type: \''.$msg['type'].'\''.$staytime.' });';
    	}
    	$html .= '})</script>';
    }

		if (!$return) {
			get_instance()->load->vars(array($variable=>$html));
		}
		
		return $html;
	}
	
	public function created($title,$redirect) {
		$this->add($title.' Created','success');
		$this->redirect($redirect);
	}
	
	public function updated($title,$redirect) {
		$this->add($title.' Updated','success');
		$this->redirect($redirect);
	}
	
	public function fail($title,$redirect) {
		$this->add('Record '.$title.' Error','error');
		$this->redirect($redirect);
	}
	
	public function redirect($url) {
  	redirect($url);
	}
	
	/* wrapper for CI instance */
	public function __get($var)
	{
		return get_instance()->$var;
	}
	
} /* end class */