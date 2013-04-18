<?php
echo $header;
echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true'));
echo form_hidden('option_id', $record->option_id);

echo crud_field('Name',form_input2('option_name',$record->option_name));
echo crud_field('Value',form_textarea('option_value', $record->option_value,'rows="3" id="textareaoption_value" class="input-xxlarge"'));
echo crud_field('Group',form_dropdown('option_group', $option_group, $record->option_group, 'class="selectcombobox"'));
echo crud_field('Auto Load',form_checkbox('auto_load', 1, $record->auto_load));

echo $endform;