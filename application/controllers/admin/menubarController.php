<?php defined('BASEPATH') OR exit('No direct script access allowed');

class menubarController extends MY_AdminController
{
	public $controller = 'menubar';
	public $page_title = 'Menu';
	public $page_titles = 'Menus';
	public $controller_model = 'menubar_model';
	public $controller_path = '/admin/menubar/';

	public function oldindexAction()
	{
		$foo = $this->controller_model->order_by('parent_id,sort')->get_all();
		$bar = $this->buildTree($this->controller_model->order_by('sort')->get_all());
		
		//var_dump($bar);
		
		$this->page
			->data('records',$bar)
			->data('parent_options',array(0=>'<i class="icon-upload"></i>') + $this->controller_model->dropdown('id','text'))
			->build();
	}

	public function indexAction()
	{

		//$treeArray = $this->buildTree($this->controller_model->order_by('sort')->get_all());
		$treeArray = $this->controller_model->order_by('sort')->get_all();
	
		ob_start();
		//$this->printTree($treeArray);
		$this->parseAndPrintTree($treeArray,0);
		$tree = ob_get_clean();
		
		$this->page
			->data('tree',$tree)
			->js('/assets/admin/js/jquery.nestable.js')
			->js('/assets/admin/js/admin_nestable.js')
			->css('/assets/admin/css/nestable.css')
			->data('parent_options',array(0=>'<i class="icon-upload"></i>') + $this->controller_model->dropdown('id','text'))
			->build();
	}
	
	public function sortAjaxPostAction()
	{
		$data['err'] = false;
		$orders = $this->input->post('order');
		$sort = 10;
		$this->orderNode($orders,$sort,0);

		$this->load->json($data);
	}

	private function orderNode($orders,$sort,$parent_id) {
		foreach ($orders as $order) {
			//echo 'Update: '.$order['id'].' Order: '.($sort++).' Parent: '.$parent.chr(10);
			
			$this->controller_model->update($order['id'], array('sort'=>(++$sort),'parent_id'=>$parent_id), true);
			
			if (isset($order['children'])) {
				$this->orderNode($order['children'],$sort,$order['id']);
			}
		}
	}

	public function newAction($parent_id=0,$parent_text='Root')
	{
		$this->controller_model->filter_parent_id($parent_id,false);

		$this->page
			->data('title','New Menu Under '.$parent_text)
			->data('action',$this->controller_path.'new')
			->data('record',(object) array('id'=>-1,'active'=>1,'parent_id'=>$parent_id))
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

	public function recordAjaxAction($id=null) {
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->controller_model->filter_id($id,false);

		$this->page
			->template('_templates/ajaxInsert')
			->data('title','Edit '.$this->page_title)
			->data('action',$this->controller_path.'edit')
			->data('record',$this->controller_model->get($id))
			->data('options',array('0'=>'Top Level') + $this->menubar->read_parents())
			->build('/admin/menubar/view');
	}

	public function editAction($id=null)
	{
		/* if somebody is sending in bogus id's send them to a fiery death */
		$this->controller_model->filter_id($id,false);

		$this->page
			->data('title','Edit '.$this->page_title)
			->data('action',$this->controller_path.'edit')
			->data('record',$this->controller_model->get($id))
			->data('options',array('0'=>'Top Level') + $this->menubar->read_parents())
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

	public function sortAjaxAction($dir=null,$id=null)
	{
		$this->data['href'] = '';
		$this->data['notice'] = array('text'=>'Menubar Sort Error','type'=>'error','stay'=>true);

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($dir)) {
			$current = $this->controller_model->get($id);

			if ($dir == 'up') {
				++$current->sort;
			} elseif ($dir == 'down') {
				--$current->sort;
			}

			if ($this->controller_model->update($id, array('sort'=>$current->sort), true)) {
				$this->flash_msg->blue($this->page_title.' Status Changed');
				$this->data['href'] = '/admin/menubar';
				$this->data['notice'] = '';
			}
		}

		$this->load->json($this->data);
	}

	public function activateAjaxAction($id=null,$mode=null)
	{
		$this->data['err'] = true;

		if ($this->controller_model->filter_id($id) && $this->controller_model->filter_mode($mode)) {
			if ($this->controller_model->update($id, array('active'=>$mode), true)) {
				$this->data['err'] = false;
			}
		}

		$this->load->json($this->data);
	}

	private function buildTree($tree, $root = 0) {
    $return = array();
    # Traverse the tree and search for direct children of the root
    foreach($tree as $record) {
      # A direct child is found
      if ($record->parent_id == $root) {
        # Remove item from tree (we don't need to traverse this again)
        //unset($tree[$record->id]);
        # Append the child into result array and parse its children
        $obj = new stdClass();
        $obj->id = $record->id;
        $obj->text = $record->text;
        $obj->url = $record->url;
        $obj->resource = $record->resource;
        $obj->active = $record->active;
        $obj->class = $record->class;
        $obj->parent_id = $record->parent_id;
        $obj->children = $this->buildTree($tree, $record->id);

        $return[] = $obj;
      }
    }
    
    return empty($return) ? null : $return;
	}
	
	private function printTree($tree) {
  
	  if (!is_null($tree) && count($tree) > 0) {
	    echo '<ol class="dd-list">';
	    foreach($tree as $node) {
	      echo '<li id="node_'.$node->id.'" class="dd-item dd3-item" data-id="'.$node->id.'">';
	      echo '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content active_'.$node->active.'">'.$node->text.' <small>'.$node->url.'</small></div>';
	      $this->printTree($node->children);
	      echo '</li>';
	    }
	    echo '</ol>';
	  }
	  
	}
	
	private function parseAndPrintTree($tree,$root) {
		if (!is_null($tree) && count($tree) > 0) {
			echo '<ol class="dd-list">';
			foreach ($tree as $node) {
				if ($node->parent_id == $root) {                    
					//unset($tree->id);
	      	echo '<li id="node_'.$node->id.'" class="dd-item dd3-item" data-id="'.$node->id.'">';
		      echo '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content active_'.$node->active.'">'.$node->text.' <small>'.$node->url.'</small></div>';
					$this->parseAndPrintTree($tree, $node->id);
					echo '</li>';
				}
			}
			echo '</ol>';
		}
	}
	
}