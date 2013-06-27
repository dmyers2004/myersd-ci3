<?php defined('BASEPATH') OR exit('No direct script access allowed');

class settingController extends MY_AdminController
{
	public $controller = 'setting';
	public $page_title = 'Setting';
	public $page_titles = 'Settings';
	public $controller_model = 'setting_model';
	public $controller_path = '/admin/setting/';

	public function indexAction()
	{
		$this->page
			->variable('records',$this->controller_model->order_by('option_group')->get_all())
			->build();
	}

	public function newAction()
	{
		$this->page
			->variable('title','New '.$this->page_title)
			->variable('action',$this->controller_path.'new')
			->variable('record',(object) array('option_id'=>-1,'auto_load'=>1))
			->variable('option_group',$this->controller_model->dropdown('option_group','option_group'))
			->build($this->controller_path.'form');
	}

	public function newValidateAjaxPostAction()
	{
		$this->load->json($this->controller_model->validate());
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
			->variable('title','Edit '.$this->page_title)
			->variable('action',$this->controller_path.'edit')
			->variable('record',$this->controller_model->get($id))
			->variable('option_group',$this->controller_model->dropdown('option_group','option_group'))
			->build($this->controller_path.'form');
	}

	public function editValidateAjaxPostAction()
	{
		$this->load->json($this->controller_model->validate());
	}

	public function editPostAction()
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('option_id');

		if ($this->controller_model->filter_id($id,false)) {
			if ($this->controller_model->map($this->data)) {
				$this->controller_model->update($this->data['option_id'], $this->data);
				$this->flash_msg->updated($this->page_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	public function deleteAjaxAction($id=null)
	{
		$this->data['err'] = true;

		/* can they delete? */
		if ($this->controller_model->filter_id($id)) {
			$this->controller_model->delete($id);
			$this->data['err'] = false;
		}

		$this->load->json($this->data);
	}

	public function activateAjaxAction($id=null,$mode=null)
	{
		$this->data['err'] = true;

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($mode)) {
			if ($this->controller_model->update($id, array('auto_load'=>$mode), true)) {
				$this->data['err'] = false;
			}
		}

		$this->load->json($this->data);
	}
}
