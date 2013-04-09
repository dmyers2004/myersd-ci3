<?php defined('BASEPATH') OR exit('No direct script access allowed');

class menubarController extends MY_AdminController {

	public $controller = 'menubar';
	public $title = 'Menu';
	public $titles = 'Menus';
	public $description = '';
	public $id_filter = 'trim|integer|filter_int[5]|exists[nav.id]';
	
	public function __construct() {
		parent::__construct();
		
		$this->data('controller',$this->controller)->data('title',$this->title)->data('titles',$this->titles)->data('description',$this->description);
	}

	public function indexAction() {
		$this->data('header',$this->load->view('admin/_partials/table_header',$this->data,true))
			->data('records',$this->menubar_model->order_by('sort')->get_all())
			->data('parent_options',$this->menubar_model->dropdown('id','text'));

		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}

	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action','/admin/'.$this->controller.'/new')
			->data('record',(object)array('option_id'=>-1,'active'=>1))
			->data('options',array('0'=>'Top Level') + $this->menubar->read_parents());

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->menubar_model->post($this->menubar_model->validate));
	}

	public function newPostAction() {
		$data = array();
		
		if ($this->input->map($this->menubar_model->validate, $data)) {
			if ($this->menubar_model->insert($data)) {
				$this->flash_msg->created($this->title,'/admin/'.$this->controller);
			}
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function editAction($id=null) {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->input->filter($id,$this->id_filter,false);

		$this->data('title','Edit '.$this->title)
			->data('action','/admin/'.$this->controller.'/edit')
			->data('record',$this->menubar_model->get($id))
			->data('options',array('0'=>'Top Level') + $this->menubar->read_parents());

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function editValidatePostAjaxAction() {
		$this->load->json($this->menubar_model->validate($this->menubar_model->validate));
	}

	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->input->filter($this->input->post('id'),$this->id_filter,false);
	
		$data = array();
		
		if ($this->input->map($this->menubar_model->validate, $data)) {
			$this->menubar_model->update($data['id'], $data);
			$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function deleteAjaxAction($id=null) {
		$data['err'] = true;

		/* can they delete? */
		if ($this->input->filter($id,$this->id_filter)) {
			$this->settings_model->delete($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}

	public function sortAjaxAction($dir=null,$id=null) {
		$data = array();
		
		$data['href'] = '';
		$data['notice'] = array('text'=>'Menubar Sort Error','type'=>'error','stay'=>true);
		
		if ($this->input->filter($id,'trim|integer|filter_int[5]') && $this->input->filter($dir,'trim|filter_str[4]')) {
			$current = $this->menubar_model->get($id);

			if ($dir == 'up') {
				++$current->sort;
			} elseif($dir == 'down')  {
				--$current->sort;
			}
			
			if ($this->menubar_model->update($id, array('sort'=>$current->sort), true)) {
				$this->flash_msg->blue($this->title.' Status Changed');
				$data['href'] = '/admin/menubar';
				$data['notice'] = '';
			}
		}

		$this->load->json($data);
	}

	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;

		if ($this->input->filter($id,$this->id_filter) && $this->input->filter($mode,'required|tf|filter_int[1]')) {
			if ($this->menubar_model->update($id, array('active'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}

}
