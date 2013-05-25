<?php 
$crud->table_header();
$crud->table_start(array('Description','Resource','Active'=>'txt-ac'));

foreach ($records as $record) {
	$crud->table_body_start();
	
	$crud->table_body_row($record->description);
	$crud->table_body_row($record->resource);
	$crud->table_body_row($crud->return_table_body_enum($record->id,$record->active),'txt-ac');
	
	$crud->table_action_start($record->id);
	$crud->table_action_row($crud->return_table_action_delete($record->id));
	$crud->table_action_end();
	
	$crud->table_body_end();
}

$crud->table_end();
