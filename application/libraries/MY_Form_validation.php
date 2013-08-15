<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	/* test */
	public function isbol($str, $field)
	{
		$this->CI->form_validation->set_message('isbol', 'The %s is invalid.');
		// test if it one of these
		$valid = array(1,'1','0',0,'on','yes','off','no','t','f','true','false');
    return (in_array(strtolower($str),$valid)) ? TRUE : FALSE;
	}
	
	/* converts  */
	public function bol2int($str, $field)
	{
		if ($this->isbol($str, $field)) {
			$this->CI->form_validation->set_message('bol2int', 'The %s is invalid.');
			$valid = array(1,'1','on','yes','t','true');
	    return (in_array(strtolower($str),$valid)) ? 1 : 0;
		}

		$this->CI->form_validation->set_message('bol2int', 'The %s is invalid.');
		return FALSE;
	}

	public function exists($str, $field)
	{
		// exists[table.column]
		list($table, $column) = explode('.', $field, 2);

		$this->CI->form_validation->set_message('exists', 'The %s that you requested is unavailable.');

		$query = $this->CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str'");
		$row = $query->row();
		return ($row->dupe > 0) ? TRUE : FALSE;
	}

	public function default($str, $field)
	{
		return (empty($str)) ? $field : $str;
	}

	public function access($str, $field)
	{
		$this->CI->form_validation->set_message('access', 'You do not have access to %s');

		$user_data = $this->CI->session->all_userdata();

		return (in_array('/*',$user_data['group_roles']) || in_array($str,$user_data['group_roles']));
	}

	public function unique($str, $field)
	{
		//unique[table.column.primary id.id]
		list($table, $column, $pri, $id) = explode('.', $field, 4);

		$this->CI->form_validation->set_message('unique', 'The %s that you requested is unavailable.');

		$row = $this->CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str' and $pri <> '$id'")->row();
		return ($row->dupe > 0) ? FALSE : TRUE;
	}

	public function acl($str, $field)
	{
		$this->CI->form_validation->set_message('acl', 'The %s is a invalid acl resource.');
		return ( ! preg_match("/^((?:\/[a-z0-9]+(?:_[a-z0-9]+)*(?:\-[a-z0-9]+)*)+)$/", $str)) ? FALSE : TRUE;
	}

	public function url($str, $field)
	{
		$this->CI->form_validation->set_message('url', 'The %s is a invalid url.');
		return ( ! preg_match('/^([\.\/-a-z0-9_-])+$/i', $str)) ? FALSE : TRUE;
	}

	public function min_date($field, $date)
	{
		$this->CI->form_validation->set_message('min_date', '%s Out of Range.');
		return (strtotime($this->posted[$field]) < strtotime($date)) ? false : true;
	}

	public function is_not($str, $field)
	{
    $this->CI->form_validation->set_message('is_not', '%s is not valid.');
    return $str!==$field;
	}
	
	public function max_date($field, $date)
	{
		$this->CI->form_validation->set_message('max_date', '%s Out of Range.');
		return (strtotime($this->posted[$field]) > strtotime($date)) ? false : true;
	}

	public function valid_date($field)
	{
		$this->CI->form_validation->set_message('valid_date', '%s Invalid.');
		$date = date_parse($this->posted[$field]);
		return checkdate($date['month'],$date['day'],$date['year']);
	}

	public function valid_dob($dob) {
		if (!preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $dob)) {
			$this->set_message('valid_dob', ERROR_DATE_WRONG_FORMAT);
			return FALSE;
		}
		
		list($d, $m, $y) = explode('/', $dob);
		
		if (!checkdate($m, $d, $y)) {
			$this->set_message('valid_dob', ERROR_DATE_INVALID);
			return FALSE;
		}
		
		if (strtotime($dob) > strtotime('-18 year', time())) {
			$this->set_message('valid_dob', ERROR_DOB_TOO_YOUNG);
			return FALSE;
		}
		
		return TRUE;
	}
    
  public function valid_time($str)
  {    
		$this->CI->form_validation->set_message('time', 'The %s is Invalid.');
    return (preg_match('/([0-9]{1,2})\:([0-9]{1,2})\:([0-9]{1,2})/', $str)) ? true : false;
  }

	public function dollars($field)
	{
		$this->CI->form_validation->set_message('dollars', 'The %s Out of Range.');
		return (!preg_match('#^\$?\d+(\.(\d{2}))?$#', $field)) ? false : true;
	}

	public function percent($field)
	{
		$this->CI->form_validation->set_message('percent', 'The %s Out of Range.');
		return (!preg_match('#^\s*(\d{0,2})(\.?(\d*))?\s*\%?$#', $field)) ? false : true;
	}
	public function zip($field)
	{
		$this->CI->form_validation->set_message('zip', 'The %s is invalid.');
		return (!preg_match('#^\d{5}$|^\d{5}-\d{4}$#', $field)) ? false : true;
	}
	public function phone($field)
	{
		$this->CI->form_validation->set_message('phone', 'The %s is invalid.');
		return (!preg_match('/^\(?([2-9]\d{2})\)?[\.\s-]?([2-4|6-9]\d\d|5([0-4-|6-9]\d|\d[0-4|6-9]))[\.\s-]?(\d{4})$/', $field)) ? false : true;
	}

	public function hexcolor($field)
	{
		$this->CI->form_validation->set_message('hexcolor', 'The %s is invalid.');
		return (!preg_match('/^#?[a-fA-F0-9]{3,6}$/', $field)) ? false : true;
	}

	public function md5($field)
	{
		$this->CI->form_validation->set_message('md5', 'The %s is invalid.');
		return (!preg_match('/^([a-zA-Z0-9]{32})$/', $field)) ? false : true;
	}

	public function base64($field)
	{
		$this->CI->form_validation->set_message('base64', 'The %s is invalid.');
		return (bool) ! preg_match('/[^a-zA-Z0-9\/\+=]/', $field);
	}

	public function alpha_extra($str)
	{
		// Alpha-numeric with periods, underscores, spaces and dashes
		$this->CI->form_validation->set_message('alpha_extra', 'The %s field may only contain alpha-numeric characters, spaces, periods, underscores, and dashes.');
		return ( ! preg_match("/^([\.\s-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;
	}

	public function matches_pattern($str, $pattern)
	{
		$this->CI->form_validation->set_message('matches_pattern', 'The %s field does not match the required pattern.');
		return (preg_match('/^' . $pattern . '$/', $str));
	}

	public function allowed_types($str, $types = NULL)
	{
		$this->CI->form_validation->set_message('allowed_types', '%s must contain one of the allowed selections.');

		// allowed_type[png,gif,jpg,jpeg]
		$type = explode(',', $types);
		$filetype = pathinfo($str['name'],PATHINFO_EXTENSION);

		return (!in_array($filetype, $type));
	}

	public function one_of($str, $options = NULL)
	{
		// one_of[1,2,3,4]
		$this->CI->form_validation->set_message('one_of', '%s must contain one of the available selections.');

		$possible_values = explode(',', $options);

		return (!in_array($str, $possible_values));
	}

	public function max_file_size($str, $size = 0)
	{
		return (bool) ($str['size']<=$size);
	}
	
  /**
   * Valid Date (ISO format)
   *
   * @access    public
   * @param    string
   * @return    bool
   */
  public function valid_date2($str)
  {
      if ( preg_match('/([0-9]{4})\-([0-9]{1,2})\-([0-9]{1,2})/', $str) ) 
      {
          $arr = explode("-", $str);
          $yyyy = $arr[0]; 
          $mm = $arr[1];
          $dd = $arr[2];
          return (checkdate($mm, $dd, $yyyy));
      }
      else
      {
          return FALSE;
      }
  }
  
  /**
   * Validate time string
   * 
   * @param mixed $str time str. 
   * @access public
   * @return boolean
   */
  public function valid_time2($str)
  {    
      if (preg_match('/([0-9]{1,2})\:([0-9]{1,2})\:([0-9]{1,2})/', $str))
          return TRUE;
      else
          return FALSE;
  }
    
	/* PHP input filters - prepping */

	public function filter_int($inp, $length)
	{
		return substr(filter_var($inp,FILTER_SANITIZE_NUMBER_INT),0,$length);
	}

	public function filter_bol($inp, $length)
	{
		return substr(filter_var($inp,FILTER_VALIDATE_BOOLEAN),0,$length);
	}

	public function filter_float($inp, $length)
	{
		return substr(filter_var($inp,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND | FILTER_FLAG_ALLOW_SCIENTIFIC),0,$length);
	}

	public function filter_str($inp, $length)
	{
		return substr(filter_var($inp,FILTER_SANITIZE_STRING),0,$length);
	}

	public function filter_url($inp, $length)
	{
		return substr(filter_var($inp,FILTER_SANITIZE_URL),0,$length);
	}

	public function filter_email($inp, $length)
	{
		return substr(filter_var($inp,FILTER_SANITIZE_EMAIL),0,$length);
	}

	public function filter_ip($inp, $length)
	{
		return substr(filter_var($inp,FILTER_VALIDATE_IP),0,$length);
	}

	public function filter_encoded($inp, $length)
	{
		return substr(filter_var($inp,FILTER_SANITIZE_ENCODED),0,$length);
	}

	public function filter_special_chars($inp, $length)
	{
		return substr(filter_var($inp,FILTER_SANITIZE_SPECIAL_CHARS),0,$length);
	}

	public function filter_raw($inp, $length)
	{
		return substr(filter_var($inp,FILTER_UNSAFE_RAW),0,$length);
	}

	public function check_captcha($val)
	{
		// !todo -- captcha
		$this->set_message('check_captcha','Captcha is incorrect');
		return true;
	}
	
	/* special add-ons */
	/* run form_validation but return a array containing everything important to it's success */
	public function run_array($group = '')
	{
		return array('err'=>!$this->run($group),'errors'=>validation_errors(),'errors_array'=>$this->error_array());
	}

	/* once a set of rules are added to form_validation you can remove one using this */
	public function remove_rules($names)
	{
		$names = explode(',',$names);

		foreach ($names as $name) {
			unset($this->_field_data[$name]);
		}

		return $this;
	}

}