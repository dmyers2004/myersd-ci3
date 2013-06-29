<?php defined('BASEPATH') OR exit('No direct script access allowed');

class accessController extends MY_AdminController
{
	public $controller = 'access';
	public $page_title = 'Access';
	public $page_titles = 'Access';
	public $controller_model = 'access_model';
	public $controller_path = '/admin/access/';

	public function indexAction()
	{
		$this->page
			->set('records',$this->controller_model->order_by('resource')->get_all())
			->build();
	}

	public function newAction()
	{
		$this->page
			->set('title','New '.$this->page_title)
			->set('action',$this->controller_path.'new')
			->set('record',(object) array('id'=>-1,'active'=>1,'type'=>0))
			->build($this->controller_path.'form');
	}

	public function newValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->validate());
	}

	public function newPostAction()
	{
		if ($this->controller_model->map($this->data)) {
			if ($this->controller_model->insert($this->data)) {
				$this->flash_msg->created($this->page_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->controller_model->filter_id($id,false);

		$this->page
			->set('title','Edit '.$this->page_title)
			->set('action',$this->controller_path.'edit')
			->set('record',$this->controller_model->get($id))
			->build($this->controller_path.'form');
	}

	public function editValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->validate());
	}

	public function editPostAction()
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->controller_model->filter_id($id,false);

		if ($this->controller_model->map($this->data)) {
			$this->controller_model->update($this->data['id'], $this->data);
			$this->flash_msg->updated($this->page_title,$this->controller_path);
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	/* ajax activate */
	public function activateAjaxAction($id=null,$mode=null)
	{
		$this->data['err'] = true;

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($mode)) {
			if ($this->controller_model->update($id, array('active'=>$mode), true)) {
				$this->data['err'] = false;
			}
		}

		$this->output->json($this->data);
	}

	public function deleteAjaxAction($id=null)
	{
		$this->data['err'] = true;

		/* can they delete? */
		if ($this->controller_model->filter_id($id)) {
			$this->controller_model->delete($id);
			$this->group_model->delete_access($id);
			$this->data['err'] = false;
		}

		$this->output->json($this->data);
	}

}
