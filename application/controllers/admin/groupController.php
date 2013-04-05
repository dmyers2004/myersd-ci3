<?php defined('BASEPATH') OR exit('No direct script access allowed');

class groupController extends MY_AdminController {

	public $controller = 'group';
	public $title = 'Group';
	public $titles = 'Groups';
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

		$this->data['records'] = $this->flexi_auth->get_groups()->result();
		
		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}
	
	public function newAction() {
		$this->data['title'] = 'New '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/new';
	
		$this->data['record'] = (object)array('ugrp_id'=>-1);
		$this->data['my_access'] = array();

		$this->data['all_access'] = $this->format_privileges($this->flexi_auth->get_privileges()->result());
		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	public function newValidatePostAjaxAction() {
		$this->load->json($this->ajax_validate());
	}

	public function newPostAction() {
		if ($this->form_validate() === false) {
			$id = $this->flexi_auth->insert_group($this->input->post('ugrp_name'), $this->input->post('ugrp_desc'));
			$this->update_privilege($id);
			$this->flash_msg->created($this->title,'/admin/'.$this->controller);
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	public function editAction($id=null) {
		$this->data['title'] = 'Edit '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/edit';
	
		$this->data['record'] = $this->flexi_auth->get_groups('*',array('ugrp_id' => $id))->row();

		$privileges = $this->flexi_auth->get_user_group_privileges('*',array('upriv_groups_ugrp_fk'=>$id))->result();
		foreach ($privileges as $record) {
			$this->data['my_access'][$record->upriv_groups_upriv_fk] = true;
		}

		$this->data['all_access'] = $this->format_privileges($this->flexi_auth->get_privileges()->result());

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}
	
	public function editValidatePostAjaxAction() {
		$this->load->json($this->ajax_validate());
	}
	
	public function editPostAction() {
		if ($this->form_validate() === false) {
			$this->flexi_auth->update_group($this->input->post('ugrp_id'), array('ugrp_name'=>$this->input->post('ugrp_name'), 'ugrp_desc'=>$this->input->post('ugrp_desc')));
			$this->update_privilege();
			$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}
	
	public function deleteAjaxAction($id=null) {
		/* can they delete? */
		$json['err'] = true;
		
		if ($this->input->filter($id,'trim|integer|filter_int[5]',true)) {
			/* if they don't have privs then nothing with be deleted and this will return false */
			$this->flexi_auth->delete_user_group_privilege(array('upriv_groups_ugrp_fk'=>$id));
			if ($this->flexi_auth->delete_group($id)) {
				$json['err'] = false;
			}
		}
 		
		$this->load->json($json);
	}
	
	protected function form_validate() {
		return $this->ajax_validate('err');
	}
	
	protected function ajax_validate($err=false) {
		$this->form_validation->set_rules('ugrp_name', 'Group Name', 'required|xss_clean');
		$this->form_validation->set_rules('ugrp_desc', 'Group Description', 'xss_clean');
		$this->form_validation->set_rules('ugrp_id', 'Id', 'required|integer');

		return $this->form_validation->json($err);
	}
	
	protected function format_privileges($privileges) {
		$formatted = array();

		foreach ($privileges as $record) {
			$namespace = array_splice(explode('/',$record->upriv_name), 1)[0];
			$formatted[$namespace][] = $record;
		}

		return $formatted;
	}

	protected function update_privilege($ugrp_id=null) {
		$ugrp_id = ($ugrp_id) ? $ugrp_id : $this->input->post('ugrp_id');
		$this->flexi_auth->delete_user_group_privilege(array('upriv_groups_ugrp_fk'=>$ugrp_id));
		foreach ($this->input->post('uprivs') as $id => $foo) {
			$this->flexi_auth->insert_user_group_privilege($ugrp_id, $id);			
		}
	}

		
}