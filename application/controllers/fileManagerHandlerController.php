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
		$options = array(
			'height'=>600,
			'width'=>'auto',
			'url'=>'/fileManagerHandler/process/',
			'resizable'=>true,
			'stand_alone'=>true,
			'bottom_footer_offset'=>20
		);

		$this->page
			->set('container',file_manager('file_manager',$options))
			->build(false,'_templates/default_basics');
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

