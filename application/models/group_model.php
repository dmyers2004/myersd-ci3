<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
*/

class group_model extends MY_Model
{
  public $_table = 'groups';
  public $group_access_table = 'group_access';
  
  public $validate = array(
  	array('field'=>'id','label'=>'Id','rules'=>'required|filter_int[5]'),
  	array('field'=>'name','label'=>'Name','rules'=>'required|filter_str[64]'),
  	array('field'=>'description','label'=>'Description','rules'=>'required|filter_str[128]')
  );

  public function insert($data, $skip_validation = false) {
		/* dump off id since it's "empty" on insert */
  	pop_off($data,'id');
		
		/* setup new validation - id is empty */
		$this->validate->remove($this->validate,'id');
		
  	return parent::insert($data, $skip_validation = false);
  }

	public function get_group_access($group_id) {
		return $query = $this->db->get_where($this->group_access_table, array('group_id' => $group_id))->result();
	}

	public function insert_group_access($access_id,$group_id) {
		return $this->db->insert($this->group_access_table, array('access_id' => $access_id,'group_id'=>$group_id));
	}
	
	public function delete_group_access($group_id) {
		$this->db->delete($this->group_access_table, array('group_id' => $group_id));
		return true;
	}
	
}