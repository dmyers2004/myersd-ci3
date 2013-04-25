<?php 
$crud->table_header();
$crud->table_start(array('Name','Email','Group','Active'=>'txt-ac'));
foreach ($records as $record) {
	$crud->table_body_start();
	
	$crud->table_body_row($record->username);
	$crud->table_body_row($record->email);
	$crud->table_body_row(anchor('/admin/group/edit/'.$record->group_id, $group_options[$record->group_id]));
	$crud->table_body_row($crud->return_table_body_active($record->id,$record->activated),'txt-ac');
	
	$crud->table_action_start($record->id);
	$crud->table_action_row($crud->return_table_action_activate($record->id,$record->activated));
	$crud->table_action_row($crud->return_table_action_delete($record->id));
	$crud->table_action_end();
	
	$crud->table_body_end();
}
$crud->table_end();
