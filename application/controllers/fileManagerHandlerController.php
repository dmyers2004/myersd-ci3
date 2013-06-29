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
		$this->page
			->set('options',$this->file_manager->options(array('standalone'=>true,'padding'=>1)))
			->build(false,'_templates/file_manager.php');
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