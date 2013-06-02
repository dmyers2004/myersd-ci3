<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flash_msg
{
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

	public function __construct()
	{
		/* drivers loads to late therefore load it here */
		get_instance()->load->driver('session');
		
		$this->tohtml();
	}

	public function red($msg,$redirect=NULL)
	{
		return $this->add($msg,'red',TRUE,$redirect);	
	}

	public function yellow($msg,$redirect=NULL)
	{
		return $this->add($msg,'yellow',FALSE,$redirect);	
	}

	public function blue($msg,$redirect=NULL)
	{
		return $this->add($msg,'blue',FALSE,$redirect);	
	}

	public function green($msg,$redirect=NULL)
	{
		return $this->add($msg,'green',FALSE,$redirect);	
	}

	public function error($msg,$redirect=NULL)
	{
		return $this->add($msg,'error',TRUE,$redirect);	
	}

	public function info($msg,$redirect=NULL)
	{
		return $this->add($msg,'info',FALSE,$redirect);	
	}

	public function block($msg,$redirect=NULL)
	{
		return $this->add($msg,'block',FALSE,$redirect);	
	}

	public function success($msg,$redirect=NULL)
	{
		return $this->add($msg,'success',FALSE,$redirect);	
	}

  /* most basic add function */
  public function add($msg='',$type='yellow',$sticky=FALSE,$redirect=null)
  {
  	$this->messages[] = array('msg'=>$msg,'type'=>$this->type[$type],'sticky'=>$sticky);
    get_instance()->session->set_flashdata('growl_flash_message_storage',$this->messages);

		if ($redirect) {
			redirect($redirect);
		}

		$this->tohtml();

		return $this;
  }

	public function tohtml($variable = 'flash_msg',$return = false)
	{
		$html = '<script src="'.$this->js.'" type="text/javascript"></script><link rel="stylesheet" href="'.$this->css.'">';

    $messages = get_instance()->session->flashdata('growl_flash_message_storage');

    if (is_array($messages)) {
    	$html .= '<script>$(document).ready(function(){';
    	foreach ($messages as $key => $msg) {
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

	public function denied($redirect=NULL) {
		$this->add('Access Denied','error',TRUE,$redirect);
	}

	public function created($title,$redirect=NULL)
	{
		$this->add($title.' Created','success',FALSE,$redirect);
	}

	public function updated($title,$redirect='')
	{
		$this->add($title.' Updated','success',FALSE,$redirect);
	}

	public function fail($title,$redirect='')
	{
		$this->add('Record '.$title.' Error','error',TRUE,$redirect);
	}

	public function redirect($url)
	{
  	redirect($url);
	}

} /* end class */
