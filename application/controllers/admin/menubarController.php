<?php defined('BASEPATH') OR exit('No direct script access allowed');

class menubarController extends MY_AdminController {

	public $controller = 'menubar';
	public $title = 'Menu';
	public $titles = 'Menus';
	public $description = '';
	
	public function __construct() {
		parent::__construct();
		
		$this->data['controller'] = $this->controller;
		$this->data['title'] = $this->title;
		$this->data['titles'] = $this->titles;
		$this->data['description'] = $this->description;
	}

	public function indexAction() {
		$this->data['header'] = $this->load->view('admin/_partials/table_header',$this->data,true);
	
		$this->data['records'] = $this->menubar_model->order_by('sort')->get_all();
		$this->data['parent_options'] = $this->menubar_model->dropdown('id','text');

		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}

	public function newAction() {
		$this->data['title'] = 'New '.$this->title.' Entry';
		$this->data['action'] = '/admin/'.$this->controller.'/new';
		$this->data['record'] = (object)array('active'=>1,'id'=>-1);
		$this->data['options'] = array('0'=>'Top Level') + $this->menubar->read_parents();

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->menubar_model->ajax_validate());
	}

	public function newPostAction() {
		$data = array();
		$this->input->map($data,'text,url,parent_id,sort,resource,text,class,active>0');

		if ($this->menubar_model->insert($data)) {
			/* insert into acl access table */
			$this->flexi_auth->insert_privilege($data['resource'], $data['text'].' '.$data['resource'].' '.$data['url']);

			$this->flash_msg->created($this->title,'/admin/'.$this->controller);
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function editAction($id=null) {
		$this->data['title'] = 'Edit '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/edit';
		$this->data['record'] = $this->menubar->get($id);
		$this->data['options'] = array('0'=>'Top Level') + $this->menubar->read_parents();

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function editValidatePostAjaxAction() {
		$this->load->json($this->menubar_model->ajax_validate());
	}

	public function editPostAction() {
		$data = array();
		$this->input->map($data,'text,url,parent_id,sort,resource,text,class,active>0');

		$id = $this->input->post('id');

		if ($this->input->filter($id,'trim|integer|filter_int[5]')) {
			$this->menubar_model->update($id,$data);			
			$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
		}

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function deleteAjaxAction($id=null) {
		$json['err'] = true;

		/* can they delete? */
		if ($this->input->filter($id,'trim|integer|filter_int[5]')) {
			if ($this->menubar_model->delete($id)) {
				$json['err'] = false;
			}
		}

		$this->load->json($json);
	}

	public function sortAjaxAction($dir=null,$id=null) {
		$json = array();
		
		if ($this->input->filter($id,'trim|integer|filter_int[5]') && $this->input->filter($dir,'trim|filter_string[4]')) {
			$current = $this->menubar_model->get($id);

			if ($dir == 'up') {
				++$current->sort;
			} elseif($dir == 'down')  {
				--$current->sort;
			}
			
			if ($this->menubar_model->update($current->id, array('sort'=>$current->sort))) {
				$this->flash_msg->blue($this->title.' Status Changed');
				$json['href'] = '/admin/menubar';
				$this->load->json($json);
				return;
			}
		}

 		$this->flash_msg->red($this->title.' Status Change Error');
		$json['href'] = '/admin/menubar';
		$this->load->json($json);
	}

	public function activateAjaxAction($id=null,$mode=null) {
		$json['err'] = true;
		if ($this->input->filter($mode,'trim|tf|filter_int[1]') && $this->input->filter($id,'integer|trim|filter_int[5]')) {
			if ($this->menubar_model->update_active($id,$mode)) {
				$json['err'] = false;
			}
		}

		$this->load->json($json);
	}
}
