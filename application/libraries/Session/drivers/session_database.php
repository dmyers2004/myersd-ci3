<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
	* This is based off the native driver
	* I simple strap on a session save handler to put it into the DB
	*/
class CI_Session_database extends CI_Session_driver {

	public $user_agent;
	public $user_ip;
	public $sess_table_name;

	/**
	 * Initialize session driver object
	 *
	 * @return	void
	 */
	protected function initialize()
	{
		
		// Get config parameters
		$config = array();
		$prefs = array(
			'sess_cookie_name',
			'sess_expire_on_close',
			'sess_expiration',
			'sess_match_ip',
			'sess_match_useragent',
			'sess_time_to_update',
			'cookie_prefix',
			'cookie_path',
			'cookie_domain',
			'cookie_secure',
			'cookie_httponly',
			'sess_use_database',
			'sess_table_name',
			'sess_hash_function',
			'sess_custom_class'
		);

		foreach ($prefs as $key)
		{
			$config[$key] = isset($this->_parent->params[$key])
				? $this->_parent->params[$key]
				: $this->CI->config->item($key);
		}

		ini_set('session.hash_function',$config['sess_hash_function']);

		$this->sess_table_name = $config['sess_table_name'];

		/*
		 ____                _               _   _                 _ _           
		/ ___|  ___  ___ ___(_) ___  _ __   | | | | __ _ _ __   __| | | ___ _ __ 
		\___ \ / _ \/ __/ __| |/ _ \| '_ \  | |_| |/ _` | '_ \ / _` | |/ _ \ '__|
		 ___) |  __/\__ \__ \ | (_) | | | | |  _  | (_| | | | | (_| | |  __/ |   
		|____/ \___||___/___/_|\___/|_| |_| |_| |_|\__,_|_| |_|\__,_|_|\___|_|   
		*/
		session_set_save_handler(
			array(&$this, 'database_open'),
			array(&$this, 'database_close'),
			array(&$this, 'database_read'),
			array(&$this, 'database_write'),
			array(&$this, 'database_destroy'),
			array(&$this, 'database_clean')
		);

		// Set session name, if specified
		if ($config['sess_cookie_name'])
		{
			// Differentiate name from cookie driver with '_id' suffix
			$name = $config['sess_cookie_name'].'_id';
			if ($config['cookie_prefix'])
			{
				// Prepend cookie prefix
				$name = $config['cookie_prefix'].$name;
			}
			session_name($name);
		}

		// Set expiration, path, and domain
		$expire = 7200;
		$path = '/';
		$domain = '';
		$secure = (bool) $config['cookie_secure'];
		$http_only = (bool) $config['cookie_httponly'];

		if ($config['sess_expiration'] !== FALSE)
		{
			// Default to 2 years if expiration is "0"
			$expire = ($config['sess_expiration'] == 0) ? (60*60*24*365*2) : $config['sess_expiration'];
		}

		if ($config['cookie_path'])
		{
			// Use specified path
			$path = $config['cookie_path'];
		}

		if ($config['cookie_domain'])
		{
			// Use specified domain
			$domain = $config['cookie_domain'];
		}

		session_set_cookie_params($config['sess_expire_on_close'] ? 0 : $expire, $path, $domain, $secure, $http_only);

		// store user agent once
		$this->user_agent = trim(substr($this->CI->input->user_agent(), 0, 50));
		
		// store user ip once
		$this->user_ip = $this->CI->input->ip_address();

		// Start session
		if (!isset($_SESSION)) {
			session_start();
		}

		// Check session expiration, ip, and agent
		$now = time();
		$destroy = FALSE;
		if (isset($_SESSION['last_activity']) && (($_SESSION['last_activity'] + $expire) < $now OR $_SESSION['last_activity'] > $now))
		{
			// Expired - destroy
			$destroy = TRUE;
		}
		elseif ($config['sess_match_ip'] === TRUE && isset($_SESSION['ip_address'])
			&& $_SESSION['ip_address'] !== $this->user_ip)
		{
			// IP doesn't match - destroy
			$destroy = TRUE;
		}
		elseif ($config['sess_match_useragent'] === TRUE && isset($_SESSION['user_agent'])
			&& $_SESSION['user_agent'] !== $this->user_agent)
		{
			// Agent doesn't match - destroy
			$destroy = TRUE;
		}

		// Destroy expired or invalid session
		if ($destroy)
		{
			// Clear old session and start new
			$this->sess_destroy();
			session_start();
		}

		// Check for update time
		if ($config['sess_time_to_update'] && isset($_SESSION['last_activity'])
			&& ($_SESSION['last_activity'] + $config['sess_time_to_update']) < $now)
		{
			// Changing the session ID amidst a series of AJAX calls causes problems
			if( ! $this->CI->input->is_ajax_request())
			{
				// Regenerate ID, but don't destroy session
				$this->sess_regenerate(FALSE);
			}
		}

		// Set activity time
		$_SESSION['last_activity'] = $now;

		// Set matching values as required
		if ($config['sess_match_ip'] === TRUE && ! isset($_SESSION['ip_address']))
		{
			// Store user IP address
			$_SESSION['ip_address'] = $this->user_ip;
		}

		if ($config['sess_match_useragent'] === TRUE && ! isset($_SESSION['user_agent']))
		{
			// Store user agent string
			$_SESSION['user_agent'] = $this->user_agent;
		}

		// Make session ID available
		$_SESSION['session_id'] = session_id();
	}

	// ------------------------------------------------------------------------

	/**
	 * Save the session data
	 *
	 * @return	void
	 */
	public function sess_save()
	{
		// Nothing to do - changes to $_SESSION are automatically saved
	}

	// ------------------------------------------------------------------------

	/**
	 * Destroy the current session
	 *
	 * @return	void
	 */
	public function sess_destroy()
	{
		// Cleanup session
		$_SESSION = array();
		$name = session_name();
		if (isset($_COOKIE[$name]))
		{
			// Clear session cookie
			$params = session_get_cookie_params();
			setcookie($name, '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
			unset($_COOKIE[$name]);
		}
		session_destroy();
	}

	// ------------------------------------------------------------------------

	/**
	 * Regenerate the current session
	 *
	 * Regenerate the session id
	 *
	 * @param	bool	Destroy session data flag (default: FALSE)
	 * @return	void
	 */
	public function sess_regenerate($destroy = FALSE)
	{
		// Just regenerate id, passing destroy flag
		session_regenerate_id($destroy);
		$_SESSION['session_id'] = session_id();
	}

	// ------------------------------------------------------------------------

	/**
	 * Get a reference to user data array
	 *
	 * @return	array	Reference to userdata
	 */
	public function &get_userdata()
	{
		// Just return reference to $_SESSION
		return $_SESSION;
	}
	
	/*
	 ____                _               _____                 _   _                 
	/ ___|  ___  ___ ___(_) ___  _ __   |  ___|   _ _ __   ___| |_(_) ___  _ __  ___ 
	\___ \ / _ \/ __/ __| |/ _ \| '_ \  | |_ | | | | '_ \ / __| __| |/ _ \| '_ \/ __|
	 ___) |  __/\__ \__ \ | (_) | | | | |  _|| |_| | | | | (__| |_| | (_) | | | \__ \
	|____/ \___||___/___/_|\___/|_| |_| |_|   \__,_|_| |_|\___|\__|_|\___/|_| |_|___/
	*/
	
	public function database_open() {
		return true;
	}
	
	public function database_close() {
		return true;
	}
	
	public function database_read($id) {
    $record = $this->CI->db->get_where($this->sess_table_name, array('session_id' => $id))->result();
    
		if (count($record) === 1) {
      return $record[0]->user_data;
    }
 
    return '';
	}

	function database_write($id, $data) {
		$data = array(
			'session_id' => $id,
			'ip_address' => $this->user_ip,
			'user_agent' => $this->user_agent,
			'last_activity' => time(),
			'user_data' => $data
		);
		$this->database_destroy($id);
    return $this->CI->db->insert($this->sess_table_name, $data);
	}

	function database_destroy($id) {
    return $this->CI->db->delete($this->sess_table_name, array('session_id' => $id)); 
	}

	function database_clean($max) {
    return $this->CI->db->where('session_id <',(time() - $max))->delete($this->sess_table_name); 
	}
	
}

/* End of file Session_database.php */
/* Location: ./application/libraries/Session/drivers/Session_database.php */