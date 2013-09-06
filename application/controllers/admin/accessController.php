<?php defined('BASEPATH') OR exit('No direct script access allowed');

class accessController extends AdminController
{
	public $controller = 'access';
	public $page_title = 'Access';
	public $page_titles = 'Access';
	public $controller_model = 'access_model';
	public $controller_path = '/admin/access/';

	public function indexAction()
	{
		$this->page
			->set('all_records',$this->format_access($this->controller_model->order_by('resource')->get_all()))
			->onready("magicheader.init({active: '.active .table-fixed-header', container: '.tab-content'});")
			->onready("$('#access-tabs a').click(function (e) { e.preventDefault(); $(this).tab('show'); }); $('#access-tabs a:first').tab('show');")
			->build();
	}

	protected function format_access($access)
	{
		$formatted = array();

		foreach ($access as $record) {

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

	public function newAction()
	{
		$this->page
			->set('section_title','New '.$this->page_title)
			->set('action',$this->controller_path.'new')
			->set('record',(object) array('id'=>-1,'active'=>1,'type'=>0))
			->build($this->controller_path.'form');
	}

	public function newValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate());
	}

	public function newPostAction()
	{
		if ($this->map->form('admin/access/form',$this->data)) {
			if ($this->controller_model->insert($this->data)) {
				$this->flash_msg->created($this->page_title,$this->controller_path);
			}
		}

		$this->flash_msg->fail($this->page_title,$this->controller_path);
	}

	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->input->filter('primaryid',$id);

		$this->page
			->set('section_title','Edit '.$this->page_title)
			->set('action',$this->controller_path.'edit')
			->set('record',$this->controller_model->get($id))
			->build($this->controller_path.'form');
	}

	public function editValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate());
	}

	public function editPostAction()
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$id = $this->input->post('id');
		$this->input->filter('primaryid',$id);

		if ($this->map->form('admin/access/form',$this->data)) {
			if ($this->controller_model->update($this->data['id'], $this->data)) {
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
		if ($this->input->filter('primaryid',$id)) {
			$this->controller_model->delete($id);
			$this->group_model->delete_access($id);
			$this->data['err'] = false;
		}

		$this->output->json($this->data);
	}

}
