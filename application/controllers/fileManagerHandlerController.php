<?php

class filemanagerhandlerController extends MY_PublicController
{
  public function __construct()
  {
    parent::__construct();

	  $this->load->library('file_manager');
  }

	/* show the stand alone file manager for ckeditor */
	public function browserAction() {
		$this->file_manager
			->addOption('height',600)
			->addOption('width','auto')
			->addOption('url','/fileManagerHandler/process/')
			->addOption('resizable',true)
			->addData('standalone',true)
			->addData('bottom_footer_offset',20)
			->addData('element_id','elfinder')
			->build();
		
		$this->page
			->variable('container','<div id="elfinder"></div>')
			->variable('no_stats',true)
			->build(false,'_templates/default_no_nav');
	}

	/* main processor for POST actions */
	public function processPostAction() {
	  $this->file_manager->process();
	}
	
	/* main processor for ajax GET actions */
	public function processAjaxAction() {
	  $this->file_manager->process();
	}

}