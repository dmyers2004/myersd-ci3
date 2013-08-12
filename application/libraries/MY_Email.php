<?php

class MY_Email extends CI_Email {

	protected $_protocols		= array('mail', 'sendmail', 'smtp', 'que', 'debug');

	public function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	protected function _send_with_que()
	{
	}
	
	protected function _send_with_debug()
	{		
		return file_put_contents(rtrim($this->mailpath,'/').'/email-'.date("mdy@gis-").uniqid().'.eml', $this->_header_str.$this->_finalbody, FILE_APPEND);
	}

}