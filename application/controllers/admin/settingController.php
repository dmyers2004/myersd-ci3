<?php defined('BASEPATH') OR exit('No direct script access allowed');

class settingController extends AdminController
{
	public $controller = 'setting';
	public $page_title = 'Setting';
	public $page_titles = 'Settings';
	public $controller_model = 'setting_model';
	public $controller_path = '/admin/setting/';

	public function indexAction()
	{
		$this->page
			->set('all_records',$this->format_settings($this->controller_model->order_by('group')->get_all()))
			->onready("magicheader.init({active: '.active .table-fixed-header', container: '.tab-content'});")
			->onready("$('#access-tabs a').click(function (e) { e.preventDefault(); $(this).tab('show'); }); $('#access-tabs a:first').tab('show');")
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
		if ($this->map->form('admin/setting/form',$this->data)) {
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
			->set('group',$this->controller_model->dropdown('group','group'))
			->build($this->controller_path.'form');
	}

	public function editValidateAjaxPostAction()
	{
		$this->output->json($this->controller_model->json_validate());
	}

	public function editPostAction()
	{

		if ($this->map->form('admin/setting/form',$this->data)) {
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
		if ($this->input->filter('primaryid',$id)) {
			$this->controller_model->delete($id);
			$this->data['err'] = false;
		}

		$this->output->json($this->data);
	}

	public function activateAjaxAction($id=null,$auto_load=null)
	{
		$this->data['err'] = true;

		if ($this->input->filter('primaryid',$id) && $this->input->filter('oneorzero',$auto_load)) {
			if ($this->controller_model->update($id, array('auto_load'=>$auto_load), true)) {
				$this->data['err'] = false;
			}
		}

		$this->output->json($this->data);
	}
	
	protected function format_settings($settings)
	{
		$formatted = array();

		foreach ($settings as $record) {
			$formatted[$record->group][] = $record;
		}

		ksort($formatted);

		return $formatted;
	}
	
} /* end settings */
