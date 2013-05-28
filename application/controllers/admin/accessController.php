<?php defined('BASEPATH') OR exit('No direct script access allowed');

class accessController extends MY_AdminController
{
	public $controller = 'access';
	public $page_title = 'Access';
	public $page_titles = 'Access';
	public $page_description = 'You can create custom permissions for different users by assigning them to groups in the Users.';
	public $controller_model = 'access_model';
	public $controller_path = '/admin/access/';

	public function indexAction()
	{
		$this->data('records',$this->controller_model->get_all())
			->page->build();
	}

	public function newAction()
	{
		$this->data('title','New '.$this->title)
			->data('action',$this->controller_path.'new')
			->data('record',(object) array('id'=>-1,'active'=>1))

			->page->build($this->controller_path.'form');
	}

	public function newValidatePostAction()
	{
		$this->load->json($this->controller_model->validate());
	}

	public function newPostAction()
	{
		if ($this->controller_model->map($this->data)) {
			if ($this->controller_model->insert($this->data)) {
				$this->flash_msg->created($this->title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->title,$this->controller_path);
	}

	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->controller_model->filter_id($id,false);

		$this->data('title','Edit '.$this->title)
			->data('action',$this->controller_path.'edit')
			->data('record',$this->controller_model->get($id))
			->page->build($this->controller_path.'form');
	}

	public function editValidatePostAction()
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
			$this->flash_msg->updated($this->title,$this->controller_path);
		}

		$this->flash_msg->fail($this->title,$this->controller_path);
	}

	/* ajax activate */
	public function activateAction($id=null,$mode=null)
	{
		$data['err'] = true;

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($mode)) {
			if ($this->controller_model->update($id, array('active'=>$mode), true)) {
				$data['err'] = false;
			}
		}

		$this->load->json($data);
	}

	public function deleteAction($id=null)
	{
		$data['err'] = true;

		/* can they delete? */
		if ($this->controller_model->filter_id($id)) {
			$this->controller_model->delete($id);
			$this->group_model->delete_access($id);
			$data['err'] = false;
		}

		$this->load->json($data);
	}

}
