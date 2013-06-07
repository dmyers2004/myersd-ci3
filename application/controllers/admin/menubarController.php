<?php defined('BASEPATH') OR exit('No direct script access allowed');

class menubarController extends MY_AdminController
{
	public $controller = 'menubar';
	public $page_title = 'Menu';
	public $page_titles = 'Menus';
	public $page_description = 'The Menubar Page allows you to create the navigation menu for use in your layouts.';
	public $controller_model = 'menubar_model';
	public $controller_path = '/admin/menubar/';

	public function indexAction()
	{
		$this->page
			->data('records',$this->controller_model->order_by('parent_id,sort')->get_all())
			->data('parent_options',array(0=>'<i class="icon-upload"></i>') + $this->controller_model->dropdown('id','text'))
			->build();
	}

	public function newAction()
	{
		$this->page
			->data('title','New '.$this->page_title)
			->data('action',$this->controller_path.'new')
			->data('record',(object) array('id'=>-1,'active'=>1))
			->data('options',array('0'=>'Top Level') + $this->menubar->read_parents())
			->build($this->controller_path.'form');
	}

	public function newValidateAjaxPostAction()
	{
		$this->load->json($this->controller_model->validate());
	}

	public function newPostAction()
	{
		if ($this->controller_model->map($this->data)) {
			if ($this->controller_model->insert($this->data)) {
				$this->flash_msg->created($this->page_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->controller_model->filter_id($id,false);

		$this->page
			->data('title','Edit '.$this->page_title)
			->data('action',$this->controller_path.'edit')
			->data('record',$this->controller_model->get($id))
			->data('options',array('0'=>'Top Level') + $this->menubar->read_parents())
			->build($this->controller_path.'form');
	}

	public function editValidateAjaxPostAction()
	{
		$this->load->json($this->controller_model->validate());
	}

	public function editPostAction()
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->controller_model->filter_id($id,false);

		if ($this->controller_model->map($this->data)) {
			$this->controller_model->update($this->data['id'], $this->data);
			$this->flash_msg->updated($this->page_title,$this->controller_path);
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	public function deleteAjaxAction($id=null)
	{
		$this->data['err'] = true;

		/* can they delete? */
		if ($this->controller_model->filter_id($id)) {
			$this->controller_model->delete($id);
			$this->data['err'] = false;
		}

		$this->load->json($this->data);
	}

	public function sortAjaxAction($dir=null,$id=null)
	{
		$this->data['href'] = '';
		$this->data['notice'] = array('text'=>'Menubar Sort Error','type'=>'error','stay'=>true);

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($dir)) {
			$current = $this->controller_model->get($id);

			if ($dir == 'up') {
				++$current->sort;
			} elseif ($dir == 'down') {
				--$current->sort;
			}

			if ($this->controller_model->update($id, array('sort'=>$current->sort), true)) {
				$this->flash_msg->blue($this->page_title.' Status Changed');
				$this->data['href'] = '/admin/menubar';
				$this->data['notice'] = '';
			}
		}

		$this->load->json($this->data);
	}

	public function activateAjaxAction($id=null,$mode=null)
	{
		$this->data['err'] = true;

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($mode)) {
			if ($this->controller_model->update($id, array('active'=>$mode), true)) {
				$this->data['err'] = false;
			}
		}

		$this->load->json($this->data);
	}

}
