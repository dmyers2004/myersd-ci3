<?php defined('BASEPATH') OR exit('No direct script access allowed');

class menubarController extends MY_AdminController
{
	public $controller = 'menubar';
	public $page_title = 'Menu';
	public $page_titles = 'Menus';
	public $controller_model = 'menubar_model';
	public $controller_path = '/admin/menubar/';
	public $tree_storage = '';

	public function indexAction()
	{
		$this->page
			->set('tree',$this->controller_model->order_by('sort')->get_all())
			->js('/assets/vendor/nestable/jquery.nestable.min.js')
			->js('/assets/vendor/nestable/nestable.min.js')
			->css('/assets/vendor/nestable/nestable.css')
			->set('parent_options',array(0=>'<i class="icon-upload"></i>') + $this->controller_model->dropdown('id','text'))
			->build();
	}
	
	public function sortAjaxPostAction()
	{
		$data['err'] = false;
		$orders = $this->input->post('order');
		$sort = 10;
		
		/* call recursive function to save the new order */
		$this->orderNode($orders,$sort,0);
		$this->load->json($data);
	}

	public function recordAjaxAction($id=null) {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->controller_model->filter_id($id,false);

		$this->load->view('/admin/menubar/view',array('record'=>$this->controller_model->get($id)));
	}

	public function newAction($parent_id=0,$parent_text='Root')
	{
		$this->controller_model->filter_parent_id($parent_id,false);

		$this->page
			->set('title','New Menu Under '.$parent_text)
			->set('action',$this->controller_path.'new')
			->set('record',(object) array('id'=>-1,'active'=>1,'parent_id'=>$parent_id))
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
			->set('title','Edit '.$this->page_title)
			->set('action',$this->controller_path.'edit')
			->set('record',$this->controller_model->get($id))
			->set('options',array('0'=>'Top Level') + $this->menubar->read_parents())
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
			$this->controller_model->update($this->data['id'], $this->data);
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
			$this->data['err'] = false;
		}

		$this->load->json($this->data);
	}

	/* recursive */
	private function orderNode($orders,$sort,$parent_id) {
		foreach ($orders as $order) {
			$this->menubar_model->update($order['id'], array('sort'=>(++$sort),'parent_id'=>$parent_id), true);
			
			if (isset($order['children'])) {
				$this->orderNode($order['children'],$sort,$order['id']);
			}
		}
	}

	
}