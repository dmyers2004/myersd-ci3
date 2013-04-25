<?php 
$crud->table_header();
$crud->table_start(array('Name','Value','Group','Autoload'=>'txt-ac'));
foreach ($records as $record) {
	$crud->table_body_start();
	
	$crud->table_body_row($record->option_name);
	$crud->table_body_row(shorten(htmlspecialchars($record->option_value),64));
	$crud->table_body_row($record->option_group);
	$crud->table_body_row($crud->return_table_body_active($record->option_id,$record->auto_load),'txt-ac');
	
	$crud->table_action_start($record->option_id);
	$crud->table_action_row($crud->return_table_action_ajax('','',$record->field,''));
	$crud->table_action_row($crud->return_table_action_activate($record->option_id,$record->auto_load));
	$crud->table_action_row($crud->return_table_action_delete($record->option_id));
	$crud->table_action_end();
	
	$crud->table_body_end();
}
$crud->table_end();
