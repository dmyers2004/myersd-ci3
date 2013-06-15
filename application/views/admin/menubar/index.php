<div class="row">
  <div class="span9">
		<h3><?=$page_titles ?><small><?=$page_description ?></small></h3>
  </div>
  <div style="padding-top: 3px;" class="span3 txt-ar">
  	<a href="/admin/<?=$controller ?>/sort" class="btn btn-small"><i class="icon-sort"></i> Reorganize <?=$page_titles ?></i></a>
  	<a href="/admin/<?=$controller ?>/new" class="btn btn-small"><i class="icon-magic"></i> Create New <?=$page_title ?></i></a>
  </div>
</div>
<?php
$crud->table_start(array('Text','URL','Active'=>'txt-ac','Parent'=>'txt-ac'));
foreach ($records as $record) {
	$crud->table_body_start();

	$crud->table_body_row($record->text);
	$crud->table_body_row($record->url);
	$crud->table_body_row($crud->return_table_body_enum($record->id,$record->active),'txt-ac');
	$crud->table_body_row($parent_options[$record->parent_id],'txt-ac');

	$crud->table_action_start($record->id);
	$crud->table_action_row($crud->return_table_action_delete($record->id));
	$crud->table_action_end();

	$crud->table_body_end();
}
$crud->table_end();
