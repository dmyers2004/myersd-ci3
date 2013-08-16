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
  protected $_table = 'groups';
  protected $group_access_table = 'group_access';

  protected $fields = array(
  	'id' => array('field'=>'id','label'=>'Id','rules'=>'required|filter_int[5]','filter'=>'trim|integer|filter_int[5]|exists[groups.id]'),
  	'name' => array('field'=>'name','label'=>'Name','rules'=>'required|filter_str[64]'),
  	'description' => array('field'=>'description','label'=>'Description','rules'=>'required|filter_str[128]')
  );

  public function insert($data, $skip_validation = false)
  {
  	unset($data['id']);
  	unset($this->validate['id']);

  	return parent::insert($data, $skip_validation);
  }

	public function get_roles($group_id)
	{
		if ($group_id == $this->config->item('admin_group_id', 'auth')) {
			/* access to everything */
			return array('/*');
		} else {
			return array(
				'/nav/dashboard',
				'/url/admin/*',
				'/url/ticket/*',
				'/nav/bugz/*',
				'/nav/*',
				'/bugz/ticket/edit/description',
				'/bugz/ticket/edit/title',
				'/bugz/ticket/edit/tags'
			);
		}

    $this->db->select('resource');
    $this->db->join('access','access.id = group_access.access_id');
    $this->db->where('group_id',$group_id);

		$access_results = $this->db->get($this->group_access_table );

		$roles = array();
		if ($access_results->num_rows() > 0) {
		  foreach ($access_results->result() as $row) {
		    $roles[] = $row->resource;
		  }
		}

		return $roles;
	}

	public function get_group_access($group_id)
	{
		return $this->db->get_where($this->group_access_table, array('group_id' => $group_id))->result();
	}

	public function insert_group_access($access_id,$group_id)
	{
		return $this->db->insert($this->group_access_table, array('access_id' => $access_id,'group_id'=>$group_id));
	}

	public function delete_group_access($group_id)
	{
		$this->db->delete($this->group_access_table, array('group_id' => $group_id));
		return true;
	}

  public function filter_id(&$id,$dieonfail=true)
  {
  	return $this->input->filter($this->fields['id']['filter'],$id,$dieonfail);
  }

  public function filter_mode(&$mode,$dieonfail=true)
  {
  	return $this->input->filter(FILTERBOL,$mode,$dieonfail);
  }

}
