<?php defined('BASEPATH') OR exit('No direct script access allowed');

class mediaController extends MY_AdminController
{
	public $controller = 'media';
	public $page_title = 'Media';
	public $page_titles = 'Media';
	public $controller_model = NULL;
	public $controller_path = '/admin/media/';

	public function indexAction()
	{
		$this->load->library('file_manager');
		
		$this->file_manager
			->addOption('height',200)
			->addOption('width','auto')
			->addOption('url','/fileManagerHandler/process/')
			->addData('element_id','elfinder')
			->addData('bottom_footer_offset',140)
			->addData('auto_resize',1)
			->build();

		$this->page
			->build();
	}
	
	public function wysiwygAction()
	{
		$this->load->library('wysiwyg');
		
		$this->wysiwyg
			->addOption('filebrowserBrowseUrl','/filemanagerhandler/browser/')
			->addOption('stylesSet','my_custom_style')
			->addOption('height','500')
			->addOption('width','auto')
			->addOption('skin','moonocolor')
			->addOption('extraPlugins','templates,youtube,htmlbuttons')
			->addData('element_id','editor1')
			->build();
		
		$this->page
			->build();
	}

}
