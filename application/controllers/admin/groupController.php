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
			->data('records',$this->controller_model->get_all())
			->build();
	}

	public function newAction()
	{
		$this->page
			->data('title','New '.$this->page_title)
			->data('action',$this->controller_path.'new')
			->data('record',(object) array('id'=>-1))
			->data('my_access',array())
			->data('all_access',$this->format_privileges($this->access_model->get_all()))
			->build($this->controller_path.'form');
	}

	public function newValidateAjaxPostAction()
	{
		$this->load->json($this->controller_model->validate());
	}

	public function newPostAction()
	{
		if ($this->controller_model->map($this->data)) {
			if ($id = $this->controller_model->insert($this->data)) {
				$this->update_privilege($id);
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
			->data('title','Edit '.$this->page_title)
			->data('action',$this->controller_path.'edit')
			->data('record',$this->controller_model->get($id))
			->data('all_access',$this->format_privileges($this->access_model->get_all()));

		$privileges = $this->controller_model->get_group_access($id);
		
		foreach ($privileges as $record) {
			$access[$record->access_id] = true;
		}

		$this->page
			->data('my_access',(array) $access)
			->build($this->controller_path.'form');
	}

	public function editValidateAjaxPostAction()
	{
		$this->load->json($this->controller_model->validate());
	}

	public function editPostAction()
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->controller_model->filter_id($id,false);

		if ($this->controller_model->map($this->data)) {
			$this->controller_model->update($this->data['id'],$this->data);
			$this->update_privilege($this->data['id']);
			$this->flash_msg->updated($this->page_title,$this->controller_path);
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	public function deleteAjaxAction($id=null)
	{
		$this->data['err'] = true;

		/* can they delete? */
		if ($this->controller_model->filter_id($id)) {
			$this->controller_model->delete($id);
			$this->controller_model->delete_group_access($id);
			$this->data['err'] = false;
		}

		$this->load->json($this->data);
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
				$name = '<i><small>* no namespace provided</small></i>';
			}

			$namespace = ($name != '') ? $name : trim(substr($resource, 0, $len),' /');

			$formatted[$namespace][] = $record;
		}

		ksort($formatted);

		return $formatted;
	}

	protected function update_privilege($group_id)
	{
		$this->controller_model->delete_group_access($group_id);
		foreach ($this->input->post('access') as $id => $foo) {
			$this->controller_model->insert_group_access($id, $group_id);
		}
	}

}
