<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
  CREATE TABLE `nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `text` varchar(64) DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `sort` tinyint(2) unsigned DEFAULT NULL,
  `class` varchar(64) DEFAULT '',
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
)
 */

class menubar_model extends MY_Model
{
  protected $_table = 'nav';
  protected $active_cache = null;
  protected $read_parents_cache = null;

  protected $fields = array(
  	'id' => array('field'=>'id','label'=>'Id','rules'=>'required|integer|filter_int[6]','filter'=>'trim|integer|filter_int[5]|exists[nav.id]'),
  	'text' => array('field'=>'text','label'=>'Text','rules'=>'required|xss_clean|filter_str[64]'),
  	'resource' => array('field'=>'resource','label'=>'Resource','rules'=>'required|xss_clean|filter_str[128]'),
  	'url' => array('field'=>'url','label'=>'Url','rules'=>'url|xss_clean|filter_str[128]'),
  	'parent_id' => array('field'=>'parent_id','label'=>'Parent Menu','rules'=>'required|integer|filter_int[5]','filter'=>'trim|integer|filter_int[5]'),
  	'sort' => array('field'=>'sort','label'=>'Sort','rules'=>'numeric|max_length[6]|filter_float[6]','default'=>0),
  	'class' => array('field'=>'class','label'=>'Class','rules'=>'xss_clean|filter_str[64]'),
  	'active' => array('field'=>'active','label'=>'Active','rules'=>'bol2int','default'=>0)
  );

	public function read_parents()
	{
		if (!$this->read_parents_cache) {
			$option = array();
	
			$query = $this->db->get_where($this->_table, array('parent_id' => 0));
	
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$option[$row->id] = $row->text;
				}
			}
		
			$this->read_parents_cache = $option;
		}

		return $this->read_parents_cache;
	}

  public function insert($data, $skip_validation = false)
  {
  	unset($data['id']);
  	unset($this->validate['id']);

  	return parent::insert($data, $skip_validation);
  }

	public function get_active()
	{
		if (!$this->active_cache) {
			$this->active_cache = $this->db->order_by('sort')->get_where($this->_table, array('active' => 1))->result_array();
		}
		return $this->active_cache;
	}

  public function filter_id(&$id,$return=false)
  {
  	return $this->input->filter($this->fields['id']['filter'],$id,$return);
  }

  public function filter_mode(&$mode,$return=false)
  {
  	return $this->input->filter(FILTERBOL,$mode,$return);
  }
  
  public function filter_parent_id(&$parent_id,$return=false)
  {
  	return $this->input->filter($this->fields['parent_id']['filter'],$parent_id,$return);
  }

}
