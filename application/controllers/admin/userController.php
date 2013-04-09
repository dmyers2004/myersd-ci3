<?php defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends MY_AdminController {

	public $controller = 'user';
	public $title = 'User';
	public $titles = 'Users';
	public $description = '';
	public $id_filter = 'trim|integer|filter_int[5]|exists[users.id]';
	public $validate = array(
		array('field'=>'id','label'=>'Id','rules'=>'required|filter_int[5]'),
		array('field'=>'username','label'=>'User Name','rules'=>'required|xss_clean|filter_str[50]'),
		array('field'=>'email','label'=>'Email','rules'=>'required|valid_email|filter_email[100]'),
		array('field'=>'group_id','label'=>'Group Id','rules'=>'required|filter_int[5]'),
		array('field'=>'confirm_password','label'=>'Confirmation Password','rules'=>'required'),
		array('field'=>'password','label'=>'Password','rules'=>'required|min_length[8]|max_length[32]|matches[confirm_password]')
	);
	
	public function __construct() {
		parent::__construct();
		
		$this->load->library('validator');
		
		$this->data('controller',$this->controller)->data('title',$this->title)->data('titles',$this->titles)->data('description',$this->description);
	}
	
	/* index view */
	public function indexAction() {
		$this->data('header',$this->load->view('admin/_partials/table_header',$this->data,true))
			->data('records',$this->tank_auth->get_users())
			->data('group_options',$this->get_groups());
		
		$this->load->template('/admin/'.$this->controller.'/index',$this->data);
	}
	
	/* create new form */
	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action','/admin/'.$this->controller.'/new')
			->data('record',(object)array('activated'=>1,'id'=>-1))
			->data('group_options',$this->get_groups());

		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	/* create new form validation */
	public function newValidatePostAjaxAction() {
		$this->load->json($this->validator->post($this->validate));
	}
	
	/* create new form post */
	public function newPostAction() {
		$data = array();

		if ($this->input->map($this->validate, $data)) {
		
		print_r($data);
		die();
		
			list($id,$username,$email,$password,$group_id) = $data;
			if ($this->tank_auth->create_user($username, $email, $password, $group_id, false)) {
				$this->flash_msg->created($this->title,'/admin/'.$this->controller);
			}
		}

		print_r(validation_errors());
		die();

		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);
	}

	/* edit form */
	public function editAction($id=null) {
		/* are they trying anything fishy? send back to the index */
		$this->input->filter($id,'trim|integer|filter_int[5]|exists[user_accounts.uacc_id]','/admin/'.$this->controller);

		$this->data['title'] = 'Edit '.$this->title;
		$this->data['action'] = '/admin/'.$this->controller.'/edit';

		$this->data['record'] = $this->flexi_auth->get_user_by_id($id)->row();
		
		$this->get_groups();
		$this->load->template('/admin/'.$this->controller.'/form',$this->data);
	}

	/* edit form validate */
	public function editValidatePostAjaxAction() {
		//$this->validate->remove_validation($this->validate,'id');
		
		$this->load->json($this->validator->post($this->validate));
	}

	/* edit form post */
	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->input->filter($this->input->post('id'),$this->id_filter,false);
	
		$data = array();
		if ($this->input->map($this->validate, $data)) {
			$this->user_model->update($data['id'], $data);
			$this->flash_msg->updated($this->title,'/admin/'.$this->controller);
		}
		
		$this->flash_msg->fail($this->title,'/admin/'.$this->controller);

/*
if ($this->input->post('uacc_password') != '') {
	$data['uacc_password'] = $this->input->post('uacc_password');
}
*/
	}
	
	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;
		
		if ($this->input->filter($id,$this->id_filter) && $this->input->filter($mode,'required|tf|filter_int[1]')) {
			if ($this->user_model->update($id, array('active'=>$mode))) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
	
	/* ajax delete */
	public function deleteAjaxAction($id=null) {		
		$data['err'] = true;

		/* can they delete? */
		if ($this->input->filter($id,$this->id_filter)) {
			$this->user_model->delete_user($id);
			$data['err'] = false;
		}
		
		$this->load->json($data);
	}
	
	/* Internal */
	protected function get_groups() {
		$dbc = $this->group_model->get_all();
		foreach ($dbc as $dbr) {
			$data[$dbr->id] = $dbr->name;
		}
		return (array)$data;
	}
	
}