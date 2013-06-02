<?php 

class CI_Session_database extends CI_Session_driver {
		protected function initialize()
		{
			// Read existing session data or create a new one
			session_start();
		}

		public function sess_save()
		{
			// Save current data to storage
		}

		public function sess_destroy()
		{
			// Destroy the current session and clean up storage
		}

		public function sess_regenerate($destroy = false)
		{
			// Create new session ID
		}

		public function &get_userdata()
		{
			// Return a reference to your userdata array
			return $_SESSION;
		}
}