<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access {

  /*
  	Loop over Array
	  $role = '/user/delete/*';
	  $role = '/user/delete/*|/isadmin';
	  $role = '/user/delete/*&/isadmin';  
  */
  public function has_role_by_group($access=NULL,$group_id=null)
  {
    if (!is_array($access) || $group_id == null) return FALSE;

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
