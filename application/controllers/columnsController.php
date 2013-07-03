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

		$cspan = 'span12';

		switch($which) {
			case 'left':
				$lspan = 'span4';
				$this->page->show('_partials/left');
				$cspan = 'span8';
			break;
			case 'right':
				$rspan = 'span4';
				$this->page->show('_partials/right');
				$cspan = 'span8';
			break;
		}

		$this->page
			->set('left_class',$lspan)
			->set('center_class',$cspan)
			->set('right_class',$rspan)
			->set('msg','2 Column '.ucfirst($which))
			->build('columns/index');
	}

	public function threeAction()
	{
		events::register('pre_partials/right',array($this,'rightcolumn'));
		events::register('pre_partials/left',array($this,'leftcolumn'));

		$this->page
			->show('_partials/left')
			->show('_partials/right')
			->set('left_class','span3')
			->set('center_class','span6')
			->set('right_class','span3')
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