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

class access_model extends MY_Model
{
	/* db table */
  protected $_table = 'access';

	protected $fields = array(
		'id' => array('field'=>'id','label'=>'Id','rules'=>'required|filter_str[5]','filter'=>'trim|integer|filter_int[5]|exists[access.id]'),
		'resource' => array('field'=>'resource','label'=>'Resource','rules'=>'required|filter_str[128]'),
		'description' => array('field'=>'description','label'=>'Description','rules'=>'required|filter_str[128]'),
		'active' => array('field'=>'active','label'=>'Active','rules'=>'filter_int[1]','default'=>0),
		'type' => array('field'=>'type','label'=>'Type','rules'=>'filter_int[1]','default'=>0),
		'module_name' => array('field'=>'module_name','label'=>'Module Name','rules'=>'filter_str[32]')
	);

  public function get_resource_id($resource)
  {
		/* did they send in a integer? then it must be the resource id already */
  	if ((int) $resource > 0) {
  		return (int) $resource;
  	}

  	$query = $this->db->get_where($this->_table, array('resource'=>$resource));

  	if ($query->num_rows() > 0) {
	  	$row = $query->result();
	  	return (int) $row[0]->id;
  	}

  	return null;
  }

  public function insert($data, $skip_validation = false)
  {
  	unset($data['id']);
		unset($this->validate['id']);

  	return parent::insert($data, $skip_validation);
  }

  public function filter_id(&$id,$return=false)
  {
  	return $this->input->filter($this->fields['id']['filter'],$id,$return);
  }

  public function filter_mode(&$mode,$return=false)
  {
  	return $this->input->filter(FILTERBOL,$mode,$return);
  }

}
