<?php defined('BASEPATH') OR exit('No direct script access allowed');

class mediaController extends AdminController
{
	public $controller = 'media';
	public $page_title = 'Media';
	public $page_titles = 'Media';
	public $controller_model = NULL;
	public $controller_path = '/admin/media/';

	public function indexAction()
	{
		$this->load->library('elfinder/Plugin_elfinder');

		$this->page
			->set('options',$this->plugin_elfinder->options(array('height'=>500,'width'=>'auto')))
			->build();
	}

	public function wysiwygAction()
	{
		$this->load->library('ckeditor/Plugin_ckeditor');

		$wysiwyg_options = array(
			'filebrowserBrowseUrl'=>'/fileManagerHandler/browser/',
			'height'=>'500',
			'width'=>'auto',
			'skin'=>'moonocolor',
			'extraPlugins'=>'templates,youtube,htmlbuttons',
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