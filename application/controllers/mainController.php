<?php defined('BASEPATH') OR exit('No direct script access allowed');

class mainController extends MY_PublicController
{
	public function indexAction()
	{
		$this->page->build();
	}

}

