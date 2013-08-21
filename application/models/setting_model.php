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
  protected $unset_on_insert = 'id';

  protected $validate = array(
  	array('field'=>'id','label'=>'Id','rules'=>'required|integer'),
  	array('field'=>'name','label'=>'Name','rules'=>'required|xss_clean'),
  	array('field'=>'value','label'=>'Value','rules'=>'required|xss_clean'),
  	array('field'=>'group','label'=>'Group','rules'=>'required|xss_clean'),
  	array('field'=>'type','label'=>'Type','rules'=>'filter_int[1]'),
  	array('field'=>'auto_load','label'=>'Autoload','rules'=>'ifempty[0]|filter_int[1]'),
  	array('field'=>'module_name','label'=>'Module Name','rules'=>'')
  );
  
} /* end setting_model */
