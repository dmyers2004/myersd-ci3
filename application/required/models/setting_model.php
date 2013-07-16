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

class setting_model extends MY_Model
{
  protected $_table = 'settings';

  protected $fields = array(
  	'id' => array('field'=>'id','label'=>'Id','rules'=>'required|integer','filter'=>'trim|filter_int[5]|exists[settings.id]'),
  	'name' => array('field'=>'name','label'=>'Name','rules'=>'required|xss_clean'),
  	'value' => array('field'=>'value','label'=>'Value','rules'=>'xss_clean'),
  	'group' => array('field'=>'group','label'=>'Group','rules'=>'required|xss_clean'),
  	'type' => array('field'=>'type','label'=>'Type','rules'=>'filter_int[1]'),
  	'auto_load' => array('field'=>'auto_load','label'=>'Autoload','rules'=>'isbol','default'=>0),
  	'module_name' => array('field'=>'module_name','label'=>'Module Name','rules'=>'')
  );

  public function insert($data, $skip_validation = false)
  {
  	unset($data['id']);
  	unset($this->validate['id']);
  	
  	return parent::insert($data, $skip_validation);
  }

  public function filter_id(&$id,$return=false)
  {
  	return $this->input->filter($this->fields['id']['filter'],$id,$return);
  }

  public function filter_mode(&$mode,$return=false)
  {
  	return ($mode == 0 || $mode == 1);
  }

}
