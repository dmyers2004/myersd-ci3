<?php 
$crud->table_header();
$crud->table_start(array('Text','URL','Sort'=>'txt-ac','Active'=>'txt-ac','Parent'=>'txt-ac'));
foreach ($records as $record) {
	$crud->table_body_start();
	
	$crud->table_body_row($record->text);
	$crud->table_body_row($record->url);
	$crud->table_body_row($record->sort,'txt-ac');
	$crud->table_body_row($crud->return_table_body_active($record->id,$record->active),'txt-ac');
	$crud->table_body_row($parent_options[$record->parent_id],'txt-ac');
	
	$crud->table_action_start($record->id);
	$crud->table_action_row($crud->return_table_action_activate($record->id,$record->active));
	$crud->table_action_row($crud->return_table_action_ajax_href('/admin/'.$controller.'/sort/up/'.$record->id,'Sort Up'));
	$crud->table_action_row($crud->return_table_action_ajax_href('/admin/'.$controller.'/sort/down/'.$record->id,'Sort Down'));
	$crud->table_action_row($crud->return_table_action_delete($record->id));
	$crud->table_action_end();
	
	$crud->table_body_end();
}
$crud->table_end();
