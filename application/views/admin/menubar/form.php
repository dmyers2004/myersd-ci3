<?php
$crud->form_start($record->id);
$crud->form_hidden('old_resource', $record->resource);

$crud->form_bs_basic('Text',form_text('text',$record->text,'input-small','Display'));
$crud->form_bs_basic('Resource',form_text('resource',$record->resource,'input-xlarge','/nav/...'));
$crud->form_bs_basic('URL',form_text('url',$record->url,'input-xlarge','/'));
$crud->form_bs_basic('Sort',form_text('sort',$record->sort,'input-mini','0','data-mask="float" maxlength="6"'));
$crud->form_bs_basic('Class',form_text('class',$record->class));
$crud->form_bs_basic('Parent Menu',form_dropdown('parent_id', $options, $record->parent_id, 'class="chosen"'));
$crud->form_bs_basic('Active',form_checkbox('active', 1, $record->active));

$crud->form_end();