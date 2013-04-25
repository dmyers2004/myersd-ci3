<?php
$crud->form_start($record->id);

$crud->field('Description',form_text('description',$record->description,'input-xxlarge','Description'));
$crud->field('Resource',form_text('resource',$record->resource,'input-xxlarge','/namespace/...'),'lowercase letters, numbers, slashes, wildcard (*)');
$crud->field('Active',form_checkbox('active', 1, $record->active));

$crud->form_end();