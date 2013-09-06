<?php

class filemanagerhandlerController extends PublicController
{
  public function __construct()
  {
    parent::__construct();

		$this->load->library('elfinder/Plugin_elfinder');
  }

	/* show the stand alone file manager for ckeditor */
	public function browserAction() {
		$this->page
			->set('options',$this->plugin_elfinder->options(array('standalone'=>true,'padding'=>1)))
			->build(false,'_templates/file_manager');
	}

	/* main processor for POST actions */
	public function processPostAction() {
	  $this->plugin_elfinder->process();
	}

	/* main processor for ajax GET actions */
	public function processAjaxAction() {
	  $this->plugin_elfinder->process();
	}

}