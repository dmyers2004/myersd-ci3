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
  protected $primary_key = 'option_id';

  protected $fields = array(
  	'option_id' => array('field'=>'option_id','label'=>'Id','rules'=>'required|integer','filter'=>'trim|filter_int[5]|exists[settings.option_id]'),
  	'option_name' => array('field'=>'option_name','label'=>'Name','rules'=>'required|xss_clean'),
  	'option_value' => array('field'=>'option_value','label'=>'Value','rules'=>'xss_clean'),
  	'option_group' => array('field'=>'option_group','label'=>'Group','rules'=>'required|xss_clean'),
  	'auto_load' => array('field'=>'auto_load','label'=>'Autoload','rules'=>'isbol','default'=>0)
  );

  public function insert($data, $skip_validation = false)
  {
  	unset($data['option_id']);
  	unset($this->validate['option_id']);
  	
  	return parent::insert($data, $skip_validation);
  }

  public function filter_id(&$id,$return=false)
  {
  	return $this->input->filter($this->fields['option_id']['filter'],$id,$return);
  }

  public function filter_mode(&$mode,$return=false)
  {
  	return ($mode == 0 || $mode == 1);
  }

}
