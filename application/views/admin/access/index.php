<?php
$crud->table_header();
$crud->table_start(array('Description','Resource','Active'=>'txt-ac','Type'=>'txt-ac'));

foreach ($records as $record) {
	$crud->table_body_start();

	$crud->table_body_row($record->description);
	$crud->table_body_row($record->resource);
	$crud->table_body_row($crud->return_table_body_enum($record->id,$record->active),'txt-ac');
	$crud->table_body_row($crud->return_enum($record->type,'<i class="icon-user"></i>|<i class="icon-cog"></i>|<i class="icon-signin"></i>'),'txt-ac');

	if ($record->type == 0) {	
		$crud->table_action_start($record->id);
		$crud->table_action_row($crud->return_table_action_delete($record->id));
		$crud->table_action_end();
	} else {
		$crud->table_body_row('');
	}

	$crud->table_body_end();
}

$crud->table_end();
?>
<h6><i class="icon-user"></i> User Entered <img width=32 height=0><i class="icon-cog"></i> System Entered <img width=32 height=0><i class="icon-signin"></i> Module Entered</h6>