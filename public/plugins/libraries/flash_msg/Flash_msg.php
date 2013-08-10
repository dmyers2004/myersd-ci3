<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*

Requires

Events Library
Page Library

*/
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
	public $CI;

	public function __construct()
	{
		/* config is local to me */
		require __DIR__.'/config.php';
		
		$this->CI = get_instance();
		
		$this->methods = $config['methods'];
		$this->initial_pause = $config['initial_pause'];
		$this->pause_for_each = $config['pause_for_each'];
		$this->js = $config['js'];
		$this->css = $config['css'];
		
		events::register('page.build',array($this,'tohtml'));
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
    $this->CI->session->set_flashdata('custom_flash_message_storage',$this->messages);

		/* redirect to another page immediately */
		if ($redirect) {
			redirect(get_instance()->paths[$redirect]);
		}

		return $this;
  }

	public function tohtml()
	{
    $messages = $this->CI->session->flashdata('custom_flash_message_storage');
		
		$html = '';
		
    if (is_array($messages)) {
    	foreach ($messages as $key => $msg) {
    	  $staytime = ($msg['sticky'] == TRUE) ? '' : ',stayTime:'.($this->pause_for_each * ($this->initial_pause++));
    		$html .= '$.noticeAdd({text:\''.$msg['msg'].'\',stay:\''.$msg['sticky'].'\',type:\''.$msg['type'].'\''.$staytime.'});';
    	}
    }

		$this->CI->page
			->js($this->js)
			->css($this->css)
			->onready($html);
	}

}