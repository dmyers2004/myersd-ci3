<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * site settings
 *
 * @package		CI Settings
 * @author		Eric Barnes <http://ericlbarnes.com>
 * @copyright	Copyright (c) Eric Barnes
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Settings Library
 *
 * Used to manage site settings
 *
 * @package		CI Settings
 * @subpackage	Libraries
 */
class Settings
{
	/**
	 * Global CI Object
	 */
	private $_ci;

	/**
	 * Settings array used to pass settings to template
	 *
	 * @access 	private
	 * @var 	array
	 */
	private $settings = array();

	/**
	 * Settings group array
	 *
	 * @access 	private
	 * @var 	array
	 */
	private $settings_group = array();

	// ------------------------------------------------------------------------

	/**
	 * Constructor assign CI instance
	 *
	 * @return 	void
	 */
	public function __construct()
	{
		$this->_ci =& get_instance();
		self::get_settings();
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Settings
	 *
	 * Get all the auto loaded settings from the db.
	 *
	 * @return	array
	 */
	public function get_settings()
	{
		// If the array is not empty we already have them.
		if ( ! empty ($this->settings)) {
			return $this->settings;
		}

		if ( ! $this->_ci->db->table_exists('settings')) {
			return FALSE;
		}

		$this->_ci->db->select('name,value')
					->from('settings')
					->where('auto_load', 1);

		$query = $this->_ci->db->get();

		if ($query->num_rows() == 0) {
			return FALSE;
		}

		foreach ($query->result() as $k => $row) {
			$this->settings[$row->name] = $row->value;
			$this->_ci->config->set_item($row->name, $row->value);
		}

		return $this->settings;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Setting (Notice Singular)
	 *
	 * Used to pull out one specific setting from the settings table.
	 *
	 * Here is an example:
	 * <code>
	 * <?php
	 * $this->settings->get_setting('site_name');
	 * ?>
	 * </code>
	 *
	 * @access	public
	 * @param	string
	 * @return	mixed
	 */
	public function get_setting($name)
	{
		if (! $name) {
			return FALSE;
		}

		// First check the auto loaded settings
		if (isset($this->settings[$name])) {
			return $this->settings[$name];
		}

		// Now lets try the settings table
		$this->_ci->db->select('value')
						->from('settings')
						->where('name', $name);

		$query = $this->_ci->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			// Add it to the main settings array
			$this->settings[$name] = $row->value;

			return $row->value;
		}

		// Still nothing. How about config?
		// This will return FALSE if not found.
		return $this->_ci->config->item($name);
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Settings By Group
	 *
	 * Get all the settings from one group
	 *
	 * @param	string
	 * @return	object
	 */
	public function get_settings_by_group($group = '')
	{
		if (! $group) {
			return FALSE;
		}

		$this->_ci->db->select('name,value')
						->from('settings')
						->where('group', $group);

		$query = $this->_ci->db->get();

		if ($query->num_rows() == 0) {
			return FALSE;
		}

		foreach ($query->result() as $k => $row) {
			$this->settings[$row->name] = $row->value;
			$arr[$row->name] = $row->value;
		}

		return $arr;
	}

	// ------------------------------------------------------------------------

	/**
	 * Edit Setting
	 *
	 * @param	string $name
	 * @param	string $value
	 * @return	bool
	 */
	public function edit_setting($name, $value)
	{
		$this->_ci->db->where('name', $name);
		$this->_ci->db->update('settings', array('value' => $value));

		if ($this->_ci->db->affected_rows() == 0) {
			return FALSE;
		}

		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete Setting by group
	 *
	 * @param	string $group
	 * @return	bool
	 */
	public function delete_settings_by_group($group)
	{
		$this->_ci->db->delete('settings', array('group' => $group));

		if ($this->_ci->db->affected_rows() == 0) {
			return FALSE;
		}

		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Add Setting
	 *
	 * Add a new setting but first check and make sure it doesn't exist already exit.
	 *
	 * @param	string $name
	 * @param	string $value
	 * @param	string $group
	 * @param	string $auto_load
	 * @return	bool
	 */
	public function add_setting($name, $value = '', $group = 'addon', $auto_load = 0, $type = 1, $module_name = '')
	{
		// Check and make sure it isn't already added.
		$this->_ci->db->select('value')
					->from('settings')
					->where('name', $name);

		$query = $this->_ci->db->get();

		if ($query->num_rows() > 0) {
			return $this->edit_setting($name, $value);
		}

		// Now insert it
		$data = array(
			'name' => $name,
			'value' => $value,
			'group' => $group,
			'auto_load' => $auto_load,
			'type' => $type,
			'module_name' => $module_name
		);

		$this->_ci->db->insert('settings', $data);

		if ($this->_ci->db->affected_rows() == 0) {
			return FALSE;
		}

		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete Setting
	 *
	 * @param	string $group
	 * @return	bool
	 */
	public function delete_setting($name)
	{
		$this->_ci->db->delete('settings', array('name' => $name));

		if ($this->_ci->db->affected_rows() == 0) {
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file Settings.php */
