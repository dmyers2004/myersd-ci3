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
  	array('field'=>'auto_load','label'=>'Autoload','rules'=>'integer|tf')
  );
	
	public function ajax_validate() {
		$json = array();
		$this->form_validation->set_error_delimiters('', '<br/>');
	
		foreach ($this->validate as $rec) {
			$data[$rec['field']] = $_POST[$rec['field']];
		}
	
		$json['err'] = !parent::validate($data);

		$errors = validation_errors();
		$json['errors'] = '<strong id="form-error-shown">Validation Error'.((count(explode('<br/>',$errors)) < 3) ? '' : 's').'</strong><br/>'.$errors;

		return $json;
	}
	
	public function update_autoload($id,$mode) {
		$this->validate = array(
			array('field'=>'option_id','label'=>'Id','rules'=>'required|integer'),
			array('field'=>'auto_load','label'=>'Active','rules'=>'integer|tf')
		);
		
		return $this->update($id,array('option_id'=>$id,'auto_load'=>$mode));
	}
	
}