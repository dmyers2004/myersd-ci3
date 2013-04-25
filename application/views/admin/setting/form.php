<?php
$crud->form_start($record->option_id,'option_id');

$crud->field('Name',form_text('option_name',$record->option_name));
$crud->field('Value',form_textarea('option_value', $record->option_value,'rows="3" id="textareaoption_value" class="input-xxlarge"'));
$crud->field('Group',form_dropdown('option_group', $option_group, $record->option_group, 'class="selectcombobox"'));
$crud->field('Auto Load',form_checkbox('auto_load', 1, $record->auto_load));

$crud->form_end();