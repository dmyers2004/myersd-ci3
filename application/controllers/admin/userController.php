<?php defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends MY_AdminController
{
	public $controller = 'user';
	public $page_title = 'User';
	public $page_titles = 'Users';
	public $controller_model = 'user_model';
	public $controller_path = '/admin/user/';

	/* index view */
	public function indexAction()
	{
		$this->page
			->set('records',$this->auth->get_users())
			->set('group_options',$this->_get_groups())
			->build();
	}

	/* create new form */
	public function newAction()
	{
		$this->page
			->set('title','New '.$this->page_title)
			->set('action',$this->controller_path.'new')
			->set('record',(object) array('activated'=>1,'id'=>-1))
			->set('group_options',$this->_get_groups())
			->build($this->controller_path.'form');
	}

	/* create new form validation */
	public function newValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate_new());
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

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	/* edit form */
	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->input->filter(FILTERINT,$id);

		$this->page
			->set('title','Edit '.$this->page_title)
			->set('action',$this->controller_path.'edit')
			->set('record',$this->controller_model->get_user($id))
			->set('group_options',$this->_get_groups())
			->build($this->controller_path.'form');
	}

	/* edit form validate */
	public function editValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate_edit());
	}

	/* edit form post */
	public function editPostAction()
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->input->filter(FILTERINT,$id);

		if ($this->controller_model->validate_edit()) {
			
			$this->controller_model->map($this->data);

			/* we don't need these in the update because they are handled differently */
			unset($this->data['confirm_password']);
			/* grab a copy for later use */
			$password = $this->data['password'];
			unset($this->data['password']);

			$this->controller_model->update_user($this->data['id'], $this->data);

			/* did they change the password? update it */
			if (!empty($password)) {
				$this->controller_model->change_password($this->data['id'], $password);
			}

			$this->flash_msg->updated($this->page_title,$this->controller_path);
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null)
	{
		$this->data['err'] = true;

		if ($this->input->filter(FILTERINT,$id) && $this->input->filter(FILTERBOL,$mode)) {
			if ($this->controller_model->update_user($id, array('activated'=>$mode))) {
				$this->data['err'] = false;
			}
		}

		$this->output->json($this->data);
	}

	/* ajax delete */
	public function deleteAjaxAction($id=null)
	{
		$this->data['err'] = true;

		/* can they delete? */
		if ($this->input->filter(FILTERINT,$id)) {
			$this->controller_model->delete_user($id);
			$this->data['err'] = false;
		}

		$this->output->json($this->data);
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
