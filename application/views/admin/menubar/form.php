<?php
$crud->form_start($record->id);
$crud->field_hidden('old_resource', $record->resource);

$crud->field('Text',form_text('text',$record->text,'input-small','Display'));
$crud->field('Resource',form_text('resource',$record->resource,'input-xlarge','/nav/...'));
$crud->field('URL',form_text('url',$record->url,'input-xlarge','/'));
$crud->field('Sort',form_text('sort',$record->sort,'input-mini','0','data-mask="float" maxlength="6"'));
$crud->field('Class',form_text('class',$record->class));
$crud->field('Parent Menu',form_dropdown('parent_id', $options, $record->parent_id, 'class="chosen"'));
$crud->field('Active',form_checkbox('active', 1, $record->active));

$crud->form_end();