<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
CREATE TABLE `settings` (
  `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` mediumtext NOT NULL,
  `option_group` varchar(55) NOT NULL DEFAULT 'site',
  `auto_load` enum('no','yes') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`,`option_name`),
  KEY `option_name` (`option_name`),
  KEY `auto_load` (`auto_load`)
)
 */

class settings_model extends MY_Model
{
  public $_table = 'settings';
  public $primary_key = 'option_id';
  
  public $validate = array(
  	array('field'=>'option_id','label'=>'Id','rules'=>'required|integer'),
  	array('field'=>'option_name','label'=>'Name','rules'=>'required|xss_clean'),
  	array('field'=>'option_value','label'=>'Value','rules'=>'xss_clean'),
  	array('field'=>'option_group','label'=>'Group','rules'=>'required|xss_clean'),
  	array('field'=>'auto_load','label'=>'Autoload','rules'=>'integer|tf','default'=>0)
  );

  public function insert($data, $skip_validation = false) {
		/* dump off id since it's "empty" on insert */
  	pop_off($data,'option_id');
		
		/* setup new validation - id is empty */
		$this->validate->remove($this->validate,'option_id');
		
  	return parent::insert($data, $skip_validation = false);
  }

}