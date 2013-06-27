<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flash_msg
{
  public $messages = array();
  
  /* required in config */
  public $methods;
  public $view_variable;
  public $initial_pause;
  public $pause_for_each;
	public $js;
	public $css;

	public function __construct()
	{
		$this->config->load('flash_msg', TRUE);
		$this->methods = $this->config->item('methods','flash_msg');
		$this->view_variable = $this->config->item('view_variable','flash_msg');
		$this->initial_pause = $this->config->item('initial_pause','flash_msg');
		$this->pause_for_each = $this->config->item('pause_for_each','flash_msg');
		$this->js = $this->config->item('js','flash_msg');
		$this->css = $this->config->item('css','flash_msg');
		
		events::register('pre_build',array($this,'tohtml'));
	}
	
	/* super method! */
	public function __call($name, $arguments) {
		/* arg1 is redirect url */
		$arguments[1] = ($arguments[1]) ? $arguments[1] : NULL;
		
		$config = array_merge(array('prep' => null, 'type'=>'success','stay'=> false),$this->methods[$name]);

		/* get the closure */
		$func = $config['prep'];
		
		/* run it if it's not null */
		if ($func) {
			$func($arguments);
		}
		
		/* send as normal add */
		return $this->add($arguments[0],$config['type'],$config['stay'],$arguments[1]);
	}

  /* most basic add function */
  public function add($msg='',$type='yellow',$sticky=FALSE,$redirect=NULL)
  {
  	$this->messages[] = array('msg'=>trim($msg),'type'=>$type,'sticky'=>$sticky);
    $this->session->set_flashdata('custom_flash_message_storage',$this->messages);

		/* redirect to another page immediately */
		if ($redirect) {
			path_redirect($redirect);
		}

		return $this;
  }

	public function tohtml($page)
	{
    $messages = $this->session->flashdata('custom_flash_message_storage');

    if (is_array($messages)) {
    	$html .= '<script>$(document).ready(function(){';
    	foreach ($messages as $key => $msg) {
    	  $staytime = ($msg['sticky'] == TRUE) ? '' : ',stayTime:'.($this->pause_for_each * ($this->initial_pause++));
    		$html .= '$.noticeAdd({text:\''.$msg['msg'].'\',stay:\''.$msg['sticky'].'\',type:\''.$msg['type'].'\''.$staytime.'});';
    	}
    	$html .= '})</script>';
    }

		$page->js($this->js)->css($this->css)->set($this->view_variable,$html);
	}
	
	/* generic wrapper for CI instance so you can $this-> in this file */
	public function __get($var)
	{
		return get_instance()->$var;
	}

}