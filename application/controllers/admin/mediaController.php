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

		$this->page
			->set('options',$this->file_manager->options(array('height'=>500,'width'=>'auto')))
			->build();

	}

	public function wysiwygAction()
	{
		$wysiwyg_options = array(
			'filebrowserBrowseUrl'=>'/fileManagerHandler/browser/',
			'height'=>'500',
			'width'=>'auto',
			'skin'=>'moonocolor',
			'extraPlugins'=>'templates,youtube,htmlbuttons',
			'js'=>'/assets/vendor/ckeditor/ckeditor.js',
			'style' => array(
				"{ name: 'My Custom Block', element: 'h3', styles: { color: 'blue'} }",
				"{ name: 'My Custom Inline', element: 'span', attributes: {'class': 'mine'} }"
			)
		);

		$this->page
			->set('wysiwyg_options',$wysiwyg_options)
			->build();
	}

}