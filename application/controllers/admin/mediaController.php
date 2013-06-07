<?php defined('BASEPATH') OR exit('No direct script access allowed');

class mediaController extends MY_AdminController
{
	public $controller = 'media';
	public $page_title = 'Media';
	public $page_titles = 'Media';
	public $page_description = 'Media Manager';
	public $controller_model = NULL;
	public $controller_path = '/admin/media/';

	public function indexAction()
	{
		$this->page
			->build();
	}

	/* move, upload, copy, new folder, delete */

}
