<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	/* test if it's 1 or 0 */
	public function tf($str, $field) {
		$this->CI->form_validation->set_message('tf', 'The %s is invalid.');
		return ((int)$str == 1 || (int)$str == 0) ? true : false;
	}

	/* exists */
	/* $this->form_validation->set_rules('username','User Name','exists[users.username]'); */
	public function exists($str, $field)
	{
		list($table, $column) = explode('.', $field, 2);

		$this->CI->form_validation->set_message('exists', 'The %s that you requested is unavailable.');

		$query = $this->CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str'");
		$row = $query->row();
		return ($row->dupe > 0) ? TRUE : FALSE;
	}

	/* access */
	public function access($str, $field)
	{
		$this->CI->form_validation->set_message('access', 'The %s that you requested is unavailable.');
		// !todo do they have access to this resource?
		return ($row->dupe > 0) ? TRUE : FALSE;
	}

	/**
	 * Unique
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	/*
	$this->form_validation->set_rules('username','User Name','required|min_length[5]|unique[users.username]');
	$this->form_validation->set_rules('emailaddress','Email Address','required|valid_email|unique[users.email]');
	*/
	public function unique($str, $field)
	{
		list($table, $column, $pri, $id) = explode('.', $field, 4);

		$this->CI->form_validation->set_message('unique', 'The %s that you requested is unavailable.');

		$row = $this->CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str' and $pri <> '$id'")->row();
		return ($row->dupe > 0) ? FALSE : TRUE;
	}

	public function acl($str, $field) {
		$this->CI->form_validation->set_message('acl', 'The %s is a invalid acl resource.');
		return ( ! preg_match("/^((?:\/[a-z0-9]+(?:_[a-z0-9]+)*(?:\-[a-z0-9]+)*)+)$/", $str)) ? FALSE : TRUE;
	}

	public function url($str, $field) {
		$this->CI->form_validation->set_message('url', 'The %s is a invalid url.');
		return ( ! preg_match('/^([\.\/-a-z0-9_-])+$/i', $str)) ? FALSE : TRUE;
	}

	public function min_date($field, $date) {
		$this->CI->form_validation->set_message('min_date', '%s Out of Range.');
		return (strtotime($this->posted[$field]) < strtotime($date)) ? false : true;
	}
	
	public function max_date($field, $date) {
		$this->CI->form_validation->set_message('max_date', '%s Out of Range.');
		return (strtotime($this->posted[$field]) > strtotime($date)) ? false : true;
	}

	public function valid_date($field) {
		$this->CI->form_validation->set_message('valid_date', '%s Invalid.');
		$date = date_parse($this->posted[$field]);
		return checkdate($date['month'],$date['day'],$date['year']);
	}

	public function dollars($field) {
		$this->CI->form_validation->set_message('dollars', 'The %s Out of Range.');
		return (!preg_match('#^\$?\d+(\.(\d{2}))?$#', $field)) ? false : true;
	}

	public function percent($field) {
		$this->CI->form_validation->set_message('percent', 'The %s Out of Range.');
		return (!preg_match('#^\s*(\d{0,2})(\.?(\d*))?\s*\%?$#', $field)) ? false : true;
	}
	public function zip($field) {
		$this->CI->form_validation->set_message('zip', 'The %s is invalid.');
		return (!preg_match('#^\d{5}$|^\d{5}-\d{4}$#', $field)) ? false : true;
	}
	public function phone($field) {
		$this->CI->form_validation->set_message('phone', 'The %s is invalid.');
		return (!preg_match('/^\(?([2-9]\d{2})\)?[\.\s-]?([2-4|6-9]\d\d|5([0-4-|6-9]\d|\d[0-4|6-9]))[\.\s-]?(\d{4})$/', $field)) ? false : true;
	}

	public function hexcolor($field) {
		$this->CI->form_validation->set_message('hexcolor', 'The %s is invalid.');
		return (!preg_match('/(^[\w\.!#$%"*+\/=?`{}|~^-]+)@(([-\w]+\.)+[A-Za-z]{2,})$/', $field)) ? false : true;
	}

	public function md5($field) {
		$this->CI->form_validation->set_message('md5', 'The %s is invalid.');
		return (!preg_match('/^([a-zA-Z0-9]{32})$/', $field)) ? false : true;
	}

	public function base64($field) {
		$this->CI->form_validation->set_message('base64', 'The %s is invalid.');
		return (bool) ! preg_match('/[^a-zA-Z0-9\/\+=]/', $field);
	}

  /**
	 * Check that a string only contains Alpha-numeric characters with
	 * periods, underscores, spaces and dashes
	 *
	 * @abstract Alpha-numeric with periods, underscores, spaces and dashes
	 * @access public
	 *
	 * @param string $str The string value to check
	 *
	 * @return	bool
	 */
	public function alpha_extra($str)
	{
		$this->CI->form_validation->set_message('alpha_extra', 'The %s field may only contain alpha-numeric characters, spaces, periods, underscores, and dashes.');
		return ( ! preg_match("/^([\.\s-a-z0-9_-])+$/i", $str)) ? FALSE : TRUE;

	}//end alpha_extra()

	// --------------------------------------------------------------------

	/**
	 * Check that the string matches a specific regex pattern
	 *
	 * @access public
	 *
	 * @param string $str     The string to check
	 * @param string $pattern The pattern used to check the string
	 *
	 * @return bool
	 */
	public function matches_pattern($str, $pattern)
	{
		if (preg_match('/^' . $pattern . '$/', $str))
		{
			return TRUE;
		}

		$this->CI->form_validation->set_message('matches_pattern', 'The %s field does not match the required pattern.');

		return FALSE;

	}//end matches_pattern()

  /**
	 * Allows setting allowed file-types in your form_validation rules.
	 * Please separate the allowed file types with a pipe or |.
	 *
	 * @author Shawn Crigger <hide@address.com>
	 * @access public
	 *
	 * @param string $str   String field name to validate
	 * @param string $types String allowed types
	 *
	 * @return bool If files are in the allowed type array then TRUE else FALSE
	 */
	public function allowed_types($str, $types = NULL)
	{
		if (!$types)
		{
			log_message('debug', 'form_validation method allowed_types was called without any allowed types.');
			return FALSE;
		}

		$type = explode(',', $types);
		$filetype = pathinfo($str['name'],PATHINFO_EXTENSION);

		if (!in_array($filetype, $type))
		{
			$this->CI->form_validation->set_message('allowed_types', '%s must contain one of the allowed selections.');
			return FALSE;
		}

		return TRUE;

	}//end allowed_types()

  /**
	 * Checks that the entered string is one of the values entered as the second parameter.
	 * Please separate the allowed file types with a comma.
	 *
	 * @access public
	 *
	 * @param string $str      String field name to validate
	 * @param string $options String allowed values
	 *
	 * @return bool If files are in the allowed type array then TRUE else FALSE
	 */
	public function one_of($str, $options = NULL)
	{
		if (!$options)
		{
			log_message('debug', 'form_validation method one_of was called without any possible values.');
			return FALSE;
		}

		log_message('debug', 'form_validation one_of options:'.$options);

		$possible_values = explode(',', $options);

		if (!in_array($str, $possible_values))
		{
			$this->CI->form_validation->set_message('one_of', '%s must contain one of the available selections.');
			return FALSE;
		}

		return TRUE;

	}//end one_of()

	/**
	 * Allows Setting maximum file upload size in your form validation rules.
	 *
	 * @author Shawn Crigger <hide@address.com>
	 * @access public
	 *
	 * @param string  $str  String field name to validate
	 * @param integer $size Integer maximum upload size in bytes
	 *
	 * @return bool
	 */
	public function max_file_size($str, $size = 0)
	{
		if ($size == 0)
		{
			log_message('error', 'Form_validation rule, max_file_size was called without setting a allowable file size.');
			return FALSE;
		}

		return (bool) ($str['size']<=$size);

	}//end max_file_size()
	
	/* PHP input filters - prepping */
	
	public function filter_int($inp, $length) {
		return substr(filter_var($inp,FILTER_SANITIZE_NUMBER_INT),0,$length);
	}

	public function filter_bol($inp, $length) {
		return substr(filter_var($inp,FILTER_VALIDATE_BOOLEAN),0,$length);
	}

	public function filter_float($inp, $length) {
		return substr(filter_var($inp,FILTER_SANITIZE_NUMBER_FLOAT),0,$length);
	}

	public function filter_str($inp, $length) {
		return substr(filter_var($inp,FILTER_SANITIZE_STRING),0,$length);
	}

	public function filter_url($inp, $length) {
		return substr(filter_var($inp,FILTER_SANITIZE_URL),0,$length);
	}

	public function filter_email($inp, $length) {
		return substr(filter_var($inp,FILTER_SANITIZE_EMAIL),0,$length);
	}

	public function filter_ip($inp, $length) {
		return substr(filter_var($inp,FILTER_VALIDATE_IP),0,$length);
	}

	public function filter_encoded($inp, $length) {
		return substr(filter_var($inp,FILTER_SANITIZE_ENCODED),0,$length);
	}

	public function filter_special_chars($inp, $length) {
		return substr(filter_var($inp,FILTER_SANITIZE_SPECIAL_CHARS),0,$length);
	}

	public function filter_raw($inp, $length) {
		return substr(filter_var($inp,FILTER_UNSAFE_RAW),0,$length);
	}	
	
	/* special */
	/* run form_validation but return a array containing everything important to it's success */
	public function run_array($group = '') {
		return array('err'=>!$this->run($group),'errors'=>validation_errors(),'errors_array'=>$this->error_array());
	}
	
	/* once a set of rules are added to form_validation you can remove one using this */
	public function remove_rules($names) {
		$names = explode(',',$names);
		
		foreach ($names as $name) {
			unset($this->_field_data[$name]);
		}
		
		return $this;
	}
	
}
