<?php
$crud->form_start($record->option_id,'option_id');

$crud->form_bs_basic('Name',form_text('option_name',$record->option_name));
$crud->form_bs_basic('Value',form_textarea('option_value', $record->option_value,'rows="3" id="textareaoption_value" class="input-xxlarge"'));
$crud->form_bs_basic('Group',form_dropdown('option_group', $option_group, $record->option_group, 'class="selectcombobox"'));
$crud->form_bs_basic('Auto Load',form_checkbox('auto_load', 1, $record->auto_load));

$crud->form_end();