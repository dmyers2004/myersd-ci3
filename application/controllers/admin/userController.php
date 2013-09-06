<?php defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends AdminController
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
			->set('section_title','New '.$this->page_title)
			->set('action',$this->controller_path.'new')
			->set('record',(object) array('activated'=>1,'id'=>-1))
			->set('group_options',$this->_get_groups())
			->set('password_format_copy',$this->user_model->password_format_copy())
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

		if ($this->map->form('admin/user/form',$this->data)) {
			if ($this->auth->create_user($this->data['username'], $this->data['email'], $this->data['password'], $this->data['group_id'], false) !== null) {
				$this->flash_msg->created($this->page_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	/* edit form */
	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->input->filter('primaryid',$id);

		$this->page
			->set('section_title','Edit '.$this->page_title)
			->set('action',$this->controller_path.'edit')
			->set('record',$this->controller_model->get_user($id))
			->set('group_options',$this->_get_groups())
			->set('password_format_copy',$this->user_model->password_format_copy())
			->onready("magicheader.init();")			
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
		if ($this->map->form('admin/user/form',$this->data)) {			
			if ($this->controller_model->update_user($this->data['id'], $this->data)) {

				/* did they change the password? update it */
				if ($this->input->post('password') !== '') {
					/* let the model clean it or what ever */
					$this->controller_model->change_password($this->data['id'], $password);
				}

				$this->flash_msg->updated($this->page_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null)
	{
		$this->data['err'] = true;

		if ($this->input->filter('primaryid',$id) && $this->input->filter('oneorzero',$mode)) {
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
		if ($this->input->filter('primaryid',$id)) {
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
