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
			->onready("magicheader.init();")
			->set('records',$this->controller_model->order_by('group')->get_all())
			->build();
	}

	public function newAction()
	{
		$this->page
			->set('section_title','New '.$this->page_title)
			->set('action',$this->controller_path.'new')
			->set('record',(object) array('id'=>-1,'auto_load'=>1,'type'=>0))
			->set('group',$this->controller_model->dropdown('group','group'))
			->build($this->controller_path.'form');
	}

	public function newValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate());
	}

	public function newPostAction()
	{
		if ($this->map->run('admin/setting/form',$this->data)) {
			if ($this->controller_model->insert($this->data)) {
				$this->flash_msg->created($this->page_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->filter->run('primaryid',$id);

		$this->page
			->set('section_title','Edit '.$this->page_title)
			->set('action',$this->controller_path.'edit')
			->set('record',$this->controller_model->get($id))
			->set('group',$this->controller_model->dropdown('group','group'))
			->build($this->controller_path.'form');
	}

	public function editValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate());
	}

	public function editPostAction()
	{

		if ($this->map->run('admin/setting/form',$this->data)) {
			if ($this->controller_model->update($this->data['id'], $this->data)) {
				$this->flash_msg->updated($this->page_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	public function deleteAjaxAction($id=null)
	{
		$this->data['err'] = true;

		/* can they delete? */
		if ($this->filter->run('primaryid',$id)) {
			$this->controller_model->delete($id);
			$this->data['err'] = false;
		}

		$this->output->json($this->data);
	}

	public function activateAjaxAction($id=null,$auto_load=null)
	{
		$this->data['err'] = true;

		if ($this->filter->run('primaryid',$id) && $this->filter->run('oneorzero',$auto_load)) {
			if ($this->controller_model->update($id, array('auto_load'=>$auto_load), true)) {
				$this->data['err'] = false;
			}
		}

		$this->output->json($this->data);
	}
} /* end settings */
