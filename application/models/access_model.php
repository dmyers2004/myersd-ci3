<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class acl_model extends CI_Model
{
  protected $group_access_table = 'group_access';
  protected $access_table = 'access';

  /*
  	Loop over Array
	  $role = '/user/delete/*';
	  $role = '/user/delete/*|/isadmin';
	  $role = '/user/delete/*&/isadmin';  
  */
  public function has_role_by_group($role=NULL,$group_id=null)
  {
    if (empty($role) || $group_id == null) return FALSE;

		$access = $this->get_by_group($group_id);

    /* string, string|string (or), string&string (and) */
    $match = NULL;

    if (strpos($role,'|') !== FALSE) {
      $responds = FALSE;
      /* or each */
      $parts = explode('|',$role);
      foreach ($parts as $part) {
        $responds = $this->in_access($part,$access) || $responds;
      }
      $match = $responds;
    }

    if (strpos($role,'&') !== FALSE) {
      $responds = TRUE;
      /* and each */
      $parts = explode('&',$role);
      foreach ($parts as $part) {
        $responds = $this->in_access($part,$access) && $responds;
      }
      $match = $responds;
    }

    if ($match == NULL) {
      $match = $this->in_access($role,$access);
    }

    return $match;
  }

	public function get_access($orderby = 'resource')
	{
		$this->db->order_by($orderby);
		$query = $this->db->get($this->access_table);

		$result = $query->result();
		$query->free_result();
		
		return $query->result_object;
	}
	
	public function update_group_access($group_id,$access=array())
	{
		$this->delete_group($group_id);

		foreach ((array)$access as $access_id => $true) {
			$this->db->insert($this->group_access_table, array('group_id'=>$group_id,'access_id'=>$access_id));
		}
				
		return $this;
	}

  public function get_by_group($group_id=null,$isadmin=false)
  {
		/* if is admin - access to EVERYTHING! */
		if ($isadmin === true) {
			return array('/*');
		}

		if ($group_id == null) {
			return array();
		}
    $access = array();

    $this->db->select('access_id,resource');
    $this->db->join('access','access.id = group_access.access_id');
    $this->db->where('group_id',$group_id);
    $this->db->where('active',1);

    $query = $this->db->get($this->group_access_table);

    if ($query->num_rows() > 0) {
	    foreach ($query->result() as $row) {
	      $access[$row->access_id] = $row->resource;
	    }
    }
  	
		return $access;  	
  }
  
  public function get_by_resource($resource) {
		/* does this resource exist? */
		$access_id = $this->get_id_by_resource($resource);

		$results = array();

		if ($access_id != null) {
	  	$query = $this->db->get_where($this->access_table, array('id' => $access_id));
	  	
	  	if ($query->num_rows() > 0) {
		  	$results = $query->result();
	  	}
		}
		
		return $results[0];
  }
  
  public function get_id_by_resource($resource) {
		/* did they send in a integer? then it must be the resource id */
  	if ((int)$resource > 0) {
  		return (int)$resource;
  	}
  
  	$query = $this->db->get_where($this->access_table, array('resource' => $resource));

  	if ($query->num_rows() > 0) {
	  	$row = $query->result();
	  	return (int)$row[0]->id;
  	}

  	return null;
  }
  
  public function insert_resource($resource,$active=1,$description='') {
		$this->db->insert($this->access_table, array('resource'=>$resource,'active'=>$active,'description'=>$description));
		
		return $this->db->insert_id();
  }
  
  public function update_resource($access_id=null,$data=array()) {
		$this->db->where('id', $access_id);
		$this->db->update($this->access_table, $data);
		
		return !$this->db->_error_number();
  }
  
  public function delete_group($group_id) {
		$this->db->delete($this->group_access_table, array('group_id' => $group_id)); 
		
		return $this->db->affected_rows();
  }
  
	public function delete_resource($resource) {
		/* get resource id */
		$access_id = $this->get_id_by_resource($resource);

		if ($access_id > 0) {
			/* delete by id in group table */
			$this->db->delete($this->group_access_table, array('access_id' => $access_id)); 

			/* delete by access_id in access table */
			$this->db->delete($this->access_table, array('id' => $access_id));
			
			return true;
		}
		
		return false;
	}
	
	/*
		Single Test
		$role = '/user/add'
		$access = array of $roles
	*/
  protected function in_access($role,$access)
  {
    $exact = (substr($role,-1) == '*') ? FALSE : TRUE;

    if (!is_array($access)) return FALSE;

    if ($exact) {
      return in_array($role,$access);
    }

    $role = substr($role,0,-1);
    foreach ($access as $a) {
      if ($role == substr($a,0,strlen($role))) {
        return TRUE;
      }
    }

    return FALSE;
  }

}