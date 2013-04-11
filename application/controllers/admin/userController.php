<?php defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends MY_AdminController {

	public $controller = 'user';
	public $title = 'User';
	public $titles = 'Users';
	public $description = 'The users page is where you manage your sites users.';
	public $default_model = 'user_model';
	public $path = '/admin/user/';	

	/* index view */
	public function indexAction() {
		$this->data('header',$this->load->view('admin/_partials/table_header',$this->data,true))
			->data('records',$this->tank_auth->get_users())
			->data('group_options',$this->get_groups());
		
		$this->load->template($this->path.'index');
	}
	
	/* create new form */
	public function newAction() {
		$this->data('title','New '.$this->title)
			->data('action',$this->path.'new')
			->data('record',(object)array('activated'=>1,'id'=>-1))
			->data('header',$this->load->view('admin/_partials/form_header',null,true))
			->data('group_options',$this->get_groups());

		$this->load->template($this->path.'form');
	}

	/* create new form validation */
	public function newValidatePostAjaxAction() {
		$this->load->json($this->default_model->validate());
	}
	
	/* create new form post */
	public function newPostAction() {

		if ($this->default_model->map($this->data)) {
			extract($this->data);			
			if ($this->tank_auth->create_user($username, $email, $password, $group_id, false)) {
				$this->flash_msg->created($this->title,$this->path);
			}
		}

		$this->flash_msg->fail($this->title,$this->path);
	}

	/* edit form */
	public function editAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->default_model->filter_id($this->input->post('id'),false);

		$this->data('title','Edit '.$this->title)
			->data('action',$this->path.'edit/'.$id)
			->data('record',$this->default_model->get_user($id))
			->data('header',$this->load->view('admin/_partials/form_header',$this->data,true))
			->data('group_options',$this->get_groups());
		
		$this->load->template($this->path.'form');
	}

	/* edit form validate */
	public function editValidatePostAjaxAction() {
		// do the password thing
		if ($this->input->post('password').$this->input->post('confirm_password') == '') {
			$this->default_model->remove_password_rules();
		}
		$this->load->json($this->default_model->validate());
	}

	/* edit form post */
	public function editPostAction() {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->default_model->filter_id($this->input->post('id'),false);
	
		if ($this->default_model->map($this->data)) {
			/* we don't need these in the update because they are handled differently */
			unset($this->data['confirm_password']);
			unset($this->data['password']);
			$this->default_model->update_user($this->data['id'], $this->data);

			/* did they change the password? update it */
			if ($this->input->post('password') != '') {
				$this->default_model->change_password($data['id'], $this->input->post('password'));
			}

			$this->flash_msg->updated($this->title,$this->path);
		}
		
		$this->flash_msg->fail($this->title,$this->path);
	}
	
	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null) {
		$data['err'] = true;
		
		if ($this->default_model->filter_id($id) && $this->default_model->filter_mode($mode)) {
			if ($this->default_model->update_user($id, array('activated'=>$mode))) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}
	
	/* ajax delete */
	public function deleteAjaxAction($id=null) {		
		$data['err'] = true;

		/* can they delete? */
		if ($this->default_model->filter_id($id)) {
			$this->default_model->delete_user($id);
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