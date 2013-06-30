<?php defined('BASEPATH') OR exit('No direct script access allowed');

class columnsController extends MY_PublicController
{
	public function indexAction()
	{
		$this->page
			->set('msg','Index')
			->build('columns/index');
	}

	public function singleAction()
	{
		$this->page
			->set('msg','Single Column')
			->build('columns/index');
	}

	public function twoAction($which=null)
	{
		events::register('pre_partials/right',array($this,'rightcolumn'));
		events::register('pre_partials/left',array($this,'leftcolumn'));

		switch($which) {
			case 'left':
				$this->page
					->set('lspan',4)
					->set('cspan',8);
					
			break;
			case 'right':
				$this->page
					->set('rspan',4)
					->set('cspan',8);
			break;
		}
		
		$this->page
			->set('msg','2 Column '.ucfirst($which))
			->build('columns/index');
	}

	public function threeAction()
	{
		events::register('pre_partials/right',array($this,'rightcolumn'));
		events::register('pre_partials/left',array($this,'leftcolumn'));

		$this->page
			->set('lspan',3)
			->set('cspan',6)
			->set('rspan',3)
			->set('msg','3 Column')
			->build('columns/index');
	}
	
	public function rightcolumn() {
		$this->page->append('page_right','<h3>Hello From the Right</h3>');
	}
	
	public function leftcolumn() {
		$this->page->append('page_left','<h3>Hello From the Left</h3>');
	}

}

