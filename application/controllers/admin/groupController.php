<?php defined('BASEPATH') OR exit('No direct script access allowed');

class groupController extends MY_AdminController
{
	public $controller = 'group';
	public $page_title = 'Group';
	public $page_titles = 'Groups';
	public $controller_model = 'group_model';
	public $controller_path = '/admin/group/';

	public function indexAction()
	{
		$this->page
			->set('records',$this->controller_model->get_all())
			->build();
	}

	public function newAction()
	{
		$this->page
			->set('section_title','New '.$this->content_title)
			->set('action',$this->controller_path.'new')
			->set('record',(object) array('id'=>-1))
			->set('my_access',array())
			->set('all_access',$this->format_privileges($this->access_model->get_all()))
			->onready("$('#access-tabs a').click(function (e) { e.preventDefault(); $(this).tab('show'); }); $('#access-tabs a:first').tab('show');")
			->onready("magicheader.init();")
			->build($this->controller_path.'form');
	}

	public function newValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate());
	}

	public function newPostAction()
	{
		if ($this->map->run('admin/group/form',$this->data)) {
			if ($id = $this->controller_model->insert($this->data)) {
				$this->update_privilege($id);
				$this->flash_msg->created($this->content_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->content_title,$this->controller_path);
	}

	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->filter->run('primaryid',$id);

		$this->page
			->set('section_title','Edit '.$this->content_title)
			->set('action',$this->controller_path.'edit')
			->set('record',$this->controller_model->get($id))
			->set('users',$this->user_model->get_users_by_group($id))
			->onready("$('#access-tabs a').click(function (e) { e.preventDefault(); $(this).tab('show'); }); $('#access-tabs a:first').tab('show');")
			->set('all_access',$this->format_privileges($this->access_model->get_all()));

		$privileges = $this->controller_model->get_group_access($id);
		
		foreach ($privileges as $record) {
			$access[$record->access_id] = true;
		}

		$this->page
			->set('my_access',(array) $access)
			->build($this->controller_path.'form');
	}

	public function editValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate());
	}

	public function editPostAction()
	{
		if ($this->map->run('admin/group/form',$this->data)) {
			if ($this->controller_model->update($this->data['id'],$this->data)) {
				if ($this->update_privilege($this->data['id'])) {
					$this->flash_msg->updated($this->content_title,$this->controller_path);
				}
			}
		}

		$this->flash_msg->fail($this->content_title,$this->controller_path);
	}

	public function deleteAjaxAction($id=null)
	{
		$this->data['err'] = true;

		/* can they delete? */
		if ($this->input->filter(FILTERINT,$id)) {
			$this->controller_model->delete($id);
			$this->controller_model->delete_group_access($id);
			$this->data['err'] = false;
		}

		$this->output->json($this->data);
	}

	protected function format_privileges($privileges)
	{
		$formatted = array();
		foreach ($privileges as $record) {

			$name = '';
			$resource = $record->resource;

			$len = strpos($resource,'/',1);

			if ($len === false) {
				$len = strpos($resource,' ',1);
			}

			if ($len === false) {
				$name = 'none*';
			}

			$namespace = ($name != '') ? $name : trim(substr($resource, 0, $len),' /');

			$formatted[$namespace][] = $record;
		}

		ksort($formatted);

		return $formatted;
	}

	protected function update_privilege($group_id)
	{
		$this->filter->run('primaryid',$group_id);
		$this->controller_model->delete_group_access($group_id);

		$access = $this->input->post('access');
		if (is_array($access)) {
			foreach ($access as $id => $foo) {
				if ($this->controller_model->insert_group_access($id, $group_id) === false) {
					return false;	
				}
			}
		}
		
		return true;
	}

}
