<?php
$crud->form_start($record->id);

$crud->form_bs_basic('Description',form_text('description',$record->description,'input-xxlarge','Description'));
$crud->form_bs_basic('Resource',form_text('resource',$record->resource,'input-xxlarge','/namespace/...'),'lowercase letters, numbers, slashes, wildcard (*)');
$crud->form_bs_basic('Active',form_checkbox('active', 1, $record->active));

$crud->form_end();
