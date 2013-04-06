<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**

CREATE TABLE `access` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `resource` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource` (`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `group_access` (
  `group_id` int(11) unsigned NOT NULL,
  `access_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

*/

class access_model extends MY_Model {

	/* db table */
  public $_table = 'access';

	/* setup our field requirements - based on CI form validator and some extra stuff for auto mapping */
	public $f_id = array('field'=>'id','label'=>'Id','rules'=>'required|filter_str[5]');
	public $f_resource = array('field'=>'resource','label'=>'Resource','rules'=>'required|filter_str[128]');	
	public $f_description = array('field'=>'description','label'=>'Description','rules'=>'required|filter_str[128]');
	public $f_active = array('field'=>'active','label'=>'Active','rules'=>'filter_int[1]','default'=>0);		

	public $validate = array();
	
	public function __construct() {
		parent::__construct();
		
		/* default validation */
		$this->validate = array($this->f_description,$this->f_resource,$this->f_id,$this->f_active);
	}
	
  public function get_resource_id($resource) {
		/* did they send in a integer? then it must be the resource id already */
  	if ((int)$resource > 0) {
  		return (int)$resource;
  	}
  
  	$query = $this->db->get_where($this->_table, array('resource'=>$resource));

  	if ($query->num_rows() > 0) {
	  	$row = $query->result();
	  	return (int)$row[0]->id;
  	}

  	return null;
  }
  
  public function insert($data,$skip_validation = false) {
		/* dump off id since it's "empty" on insert */
  	pop_off($data,'id');
		
		/* setup new validation - id is empty */
		$this->validate = array($this->f_description,$this->f_resource,$this->f_active);
		
  	return parent::insert($data,$skip_validation);
  }
  
}