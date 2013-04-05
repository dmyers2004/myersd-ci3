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
  
  public $validate = array();

	public function insert_group_access($access_id,$group_id) {
		$this->delete_group_access($access_id,$group_id);
		return $this->db->insert($this->users_groups_table, array('user_id' => $access_id,'group_id'=>$group_id));
	}
	
	public function delete_group_access($access_id,$group_id) {
		$this->db->delete($this->group_access_table, array('access_id' => $access_id,'group_id'=>$group_id));
		return true;
	}
	
}