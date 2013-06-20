<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flash_msg
{
	private $CI = null;

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
		$this->CI = get_instance();
		$this->CI->config->load('flash_msg', TRUE);
		$this->methods = $this->CI->config->item('methods','flash_msg');
		$this->view_variable = $this->CI->config->item('view_variable','flash_msg');
		$this->initial_pause = $this->CI->config->item('initial_pause','flash_msg');
		$this->pause_for_each = $this->CI->config->item('pause_for_each','flash_msg');
		$this->js = $this->CI->config->item('js','flash_msg');
		$this->css = $this->CI->config->item('css','flash_msg');
		
		$this->tohtml();
	}
	
	/* super method! */
	public function __call($name, $arguments) {
		/* redirect */
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
    $this->CI->session->set_flashdata('custom_flash_message_storage',$this->messages);

		if ($redirect) {
			redirect($this->CI->paths[$redirect]);
		}

		$this->tohtml();

		return $this;
  }

	public function tohtml($variable = null,$return = false)
	{
		$variable = ($variable) ? $variable : $this->view_variable;
		
		get_instance()->page->js($this->js)->css($this->css);

    $messages = $this->CI->session->flashdata('custom_flash_message_storage');

    if (is_array($messages)) {
    	$html .= '<script>$(document).ready(function(){';
    	foreach ($messages as $key => $msg) {
    	  $staytime = ($msg['sticky'] == TRUE) ? '' : ', stayTime: '.($this->pause_for_each * ($this->initial_pause++));
    		$html .= 'jQuery.noticeAdd({ text: \''.$msg['msg'].'\', stay: \''.$msg['sticky'].'\', type: \''.$msg['type'].'\''.$staytime.' });';
    	}
    	$html .= '})</script>';
    }

		if (!$return) {
			$this->CI->load->vars(array($variable=>$html));
		}

		return $html;
	}

}