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
  public $_table = 'nav';
  
  public $validate = array(
  	array('field'=>'id','label'=>'Id','rules'=>'required|integer|filter_int[6]'),
  	array('field'=>'resource','label'=>'Resource','rules'=>'required|xss_clean|filter_str[128]'),
  	array('field'=>'url','label'=>'Url','rules'=>'url|xss_clean|filter_str[128]'),
  	array('field'=>'text','label'=>'Text','rules'=>'required|xss_clean|filter_str[64]'),
  	array('field'=>'parent_id','label'=>'Parent Menu','rules'=>'required|integer|filter_int[5]'),
  	array('field'=>'sort','label'=>'Sort','rules'=>'numeric|max_length[6]|filter_float[6]'),
  	array('field'=>'class','label'=>'Class','rules'=>'xss_clean|filter_str[64]'),
  	array('field'=>'active','label'=>'Active','rules'=>'integer|tf|filter_int[1]','default'=>0)
  );

	public $filters = array(
		'id'=>'trim|integer|filter_int[5]|exists[nav.id]',
		'mode'=>'trim|tf|filter_int[1]'
	);
  
	public function read_parents() {
		$option = array();
		
		$query = $this->db->get_where($this->_table, array('parent_id' => 0));

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$option[$row->id] = $row->text;
			}
		}

		return $option;
	}

  public function insert($data, $skip_validation = false) {
  	unset($data['id']);
  	unset($this->validate[0]);
		
  	return parent::insert($data, $skip_validation);
  }
	
	public function get_active() {
		return $this->db->order_by('sort')->get_where($this->_table, array('active' => 1))->result_array();
	}

  public function filter_id(&$id,$return=false) {
  	return $this->filter($this->filters['id'],$id,$return);
  }

  public function filter_mode(&$mode,$return=false) {
  	return $this->filter($this->filters['mode'],$mode,$return);
  }
		
}