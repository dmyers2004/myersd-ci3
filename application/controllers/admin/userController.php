<?php defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends MY_AdminController
{
	public $controller = 'user';
	public $page_title = 'User';
	public $page_titles = 'Users';
	public $page_description = 'The users page is where you manage your sites users.';
	public $controller_model = 'user_model';
	public $controller_path = '/admin/user/';

	/* index view */
	public function indexAction()
	{
		$this->page
			->data('records',$this->auth->get_users())
			->data('group_options',$this->_get_groups())
			->build();
	}

	/* create new form */
	public function newAction()
	{
		$this->page
			->data('title','New '.$this->page_title)
			->data('action',$this->controller_path.'new')
			->data('record',(object) array('activated'=>1,'id'=>-1))
			->data('group_options',$this->_get_groups())
			->build($this->controller_path.'form');
	}

	/* create new form validation */
	public function newValidateAjaxPostAction()
	{
		$this->load->json($this->controller_model->validate_new());
	}

	/* create new form post */
	public function newPostAction()
	{

		if ($this->controller_model->map($this->data)) {
			extract($this->data);
			if ($this->auth->create_user($username, $email, $password, $group_id, false)) {
				$this->flash_msg->created($this->page_title,$this->controller_path);
			}
		}

		// $err = $this->auth->get_error_message();

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	/* edit form */
	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->controller_model->filter_id($id,false);

		$this->page
			->data('title','Edit '.$this->page_title)
			->data('action',$this->controller_path.'edit')
			->data('record',$this->controller_model->get_user($id))
			->data('group_options',$this->_get_groups())
			->build($this->controller_path.'form');
	}

	/* edit form validate */
	public function editValidateAjaxPostAction()
	{
		$this->load->json($this->controller_model->validate_edit());
	}

	/* edit form post */
	public function editPostAction()
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->controller_model->filter_id($id,false);

		if ($this->controller_model->map($this->data)) {
			/* we don't need these in the update because they are handled differently */
			unset($this->data['confirm_password']);
			unset($this->data['password']);
			$this->controller_model->update_user($this->data['id'], $this->data);

			/* did they change the password? update it */
			if ($this->input->post('password') != '') {
				$this->controller_model->change_password($this->data['id'], $this->input->post('password'));
			}

			$this->flash_msg->updated($this->page_title,$this->controller_path);
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null)
	{
		$this->data['err'] = true;

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($mode)) {
			if ($this->controller_model->update_user($id, array('activated'=>$mode))) {
				$this->data['err'] = false;
			}
		}

		$this->load->json($this->data);
	}

	/* ajax delete */
	public function deleteAjaxAction($id=null)
	{
		$this->data['err'] = true;

		/* can they delete? */
		if ($this->controller_model->filter_id($id)) {
			$this->controller_model->delete_user($id);
			$this->data['err'] = false;
		}

		$this->load->json($this->data);
	}

	/* Internal */
	protected function _get_groups()
	{
		$group = array();
		$dbc = $this->group_model->get_all();
		foreach ($dbc as $dbr) {
			$group[$dbr->id] = $dbr->name;
		}
		return $group;
	}

}
