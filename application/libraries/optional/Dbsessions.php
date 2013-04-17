<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

CREATE TABLE dbsessions
(
    id varchar(32) NOT NULL,
    access int(10) unsigned,
    data text,
    PRIMARY KEY (id)
);

+--------+------------------+------+-----+---------+-------+
| Field  | Type             | Null | Key | Default | Extra |
+--------+------------------+------+-----+---------+-------+
| id     | varchar(32)      |      | PRI |         |       |
| access | int(10) unsigned | YES  |     | NULL    |       |
| data   | text             | YES  |     | NULL    |       |
+--------+------------------+------+-----+---------+-------+

Memory Table

CREATE TABLE `dbsessions` (
  `id` varchar(32) NOT NULL,
  `access` int(10) unsigned DEFAULT NULL,
  `data` varchar(4096),
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

*/

class dbsessions {

	public $db_table = 'dbsessions';
	public $session_db_handle;

	function open() {
    $db_user = 'root';
    $db_pass = 'root';
    $db_host = 'localhost';
    $db_database = 'serverstatus';
    
    if ($this->session_db_handle = mysql_connect($db_host, $db_user, $db_pass)) {
      return mysql_select_db($db_database, $this->session_db_handle);
    }
    
    return FALSE;
	}
	
	function close() {
    return mysql_close($this->session_db_handle);
	}
	
	function read($id) {

    if ($dbc = mysql_query("SELECT data FROM ".$this->db_table." WHERE  id = '".mysql_real_escape_string($id)."'", $this->session_db_handle)) {
      if (mysql_num_rows($dbc)) {
        $dbr = mysql_fetch_assoc($dbc);
        return $dbr['data'];
      }
    }

    return '';
	}
	
	function write($id, $data) {   
    return mysql_query("REPLACE INTO ".$this->db_table." VALUES  ('".mysql_real_escape_string($id)."', '".mysql_real_escape_string(time())."', '".mysql_real_escape_string($data)."')", $this->session_db_handle);
	}
	
	function destroy($id) {
    return mysql_query("DELETE FROM ".$this->db_table." WHERE  id = '".mysql_real_escape_string($id)."'", $this->session_db_handle);
	}
	
	function clean($max) {
    return mysql_query("DELETE FROM ".$this->db_table." WHERE  access < '".mysql_real_escape_string(time() - $max)."'", $this->session_db_handle);
	}
}

$dbsession = new dbsessions;

session_set_save_handler(
	array(&$dbsession,'open'),
  array(&$dbsession,'close'),
  array(&$dbsession,'read'),
  array(&$dbsession,'write'),
  array(&$dbsession,'destroy'),
  array(&$dbsession,'clean')
);