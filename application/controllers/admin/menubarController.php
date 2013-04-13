<?php defined('BASEPATH') OR exit('No direct script access allowed');

class menubarController extends MY_AdminController {

	public $controller = 'menubar';
	public $title = 'Menu';
	public $titles = 'Menus';
	public $description = 'The Menubar Page allows you to create navigation groups and use them in your layouts.';
	public $default_model = 'menubar_model';
	public $path = '/admin/menubar/';		
	
	public function indexAction() {
		$this->data('header',$this->load->partial('admin/_partials/table_header'))
			->data('records',$this->default_model->order_by('parent_id,sort')->get_all())
			->data('parent_options',$this->default_model->dropdown('id','text'))
			->load->template($this->path.'index');
	}

	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action',$this->path.'new')
			->data('record',(object)array('option_id'=>-1,'active'=>1))
			->data('header',$this->load->partial('admin/_partials/form_header'))
			->data('options',array('0'=>'Top Level') + $this->menubar->read_parents())
			
			->load->template($this->path.'form');
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->default_model->validate());
	}

	public function newPostAction() {

		if ($this->default_model->map($this->data)) {
			if ($this->default_model->insert($this->data)) {
				$this->flash_msg->created($this->title,$this->path);
			}
		}

		$this->flash_msg->fail($this->title,$this->path);
	}

	public function editAction($id=null) {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->default_model->filter_id($id,false);

		$this->data('title','Edit '.$this->title)
			->data('action',$this->path.'edit')
			->data('record',$this->default_model->get($id))
			->data('header',$this->load->partial('admin/_partials/form_header'))
			->data('options',array('0'=>'Top Level') + $this->menubar->read_parents())
			
			->load->template($this->path.'form');
	}

	public function editValidatePostAjaxAction() {
		$this->load->json($this->default_model->validate());
	}

	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->default_model->filter_id($id,false);
			
		if ($this->default_model->map($this->data)) {
			$this->default_model->update($this->data['id'], $this->data);
			$this->flash_msg->updated($this->title,$this->path);
		}
		
		$this->flash_msg->fail($this->title,$this->path);
	}

	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->default_model->filter_id($id)) {
			$this->default_model->delete($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}

	public function sortAjaxAction($dir=null,$id=null) {		
		$data['href'] = '';
		$data['notice'] = array('text'=>'Menubar Sort Error','type'=>'error','stay'=>true);
		
		if ($this->default_model->filter_id($id) && $this->default_model->filter_mode($dir)) {
			$current = $this->default_model->get($id);

			if ($dir == 'up') {
				++$current->sort;
			} elseif($dir == 'down')  {
				--$current->sort;
			}
			
			if ($this->default_model->update($id, array('sort'=>$current->sort), true)) {
				$this->flash_msg->blue($this->title.' Status Changed');
				$data['href'] = '/admin/menubar';
				$data['notice'] = '';
			}
		}

		$this->load->json($data);
	}

	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;

		if ($this->default_model->filter_id($id) && $this->default_model->filter_mode($mode)) {
			if ($this->default_model->update($id, array('active'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}

}
