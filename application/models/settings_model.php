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
  
  public $f_option_id = array('field'=>'option_id','label'=>'Id','rules'=>'required|integer');
  public $f_option_name = array('field'=>'option_name','label'=>'Name','rules'=>'required|xss_clean');
  public $f_option_value = array('field'=>'option_value','label'=>'Value','rules'=>'xss_clean');
  public $f_option_group = array('field'=>'option_group','label'=>'Group','rules'=>'required|xss_clean');
  public $f_auto_load = array('field'=>'auto_load','label'=>'Autoload','rules'=>'integer|tf');
  
  public $validate = array();

	public function __construct() {
		parent::__construct();
		
		/* default validation */
		$this->validate = array($this->f_option_id,$this->f_option_name,$this->f_option_value,$this->f_option_group,$this->f_auto_load);
	}

  public function insert($data,$skip_validation = false) {
		/* dump off id since it's "empty" on insert */
  	pop_off($data,'option_id');
		
		/* setup new validation - id is empty */
		$this->validate->remove($this->validate,'option_id');
		
  	return parent::insert($data,$skip_validation);
  }

}