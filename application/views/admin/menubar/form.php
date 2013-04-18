<?php
echo $header
echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true'))
echo form_hidden('id', $record->id);
echo form_hidden('old_resource', $record->resource);

echo crud_field('Text',form_input2('text',$record->text,'input-small','Display'));
echo crud_field('Resource',form_input2('resource',$record->resource,'input-xlarge','/nav/...'));
echo crud_field('URL',form_input2('url',$record->url,'input-xlarge','/'));
echo crud_field('Sort',form_input2('sort',$record->sort,'input-mini','0','data-mask="float" maxlength="6"'));
echo crud_field('Class',form_input2('class',$record->class));
echo crud_field('Parent Menu',form_dropdown('parent_id', $options, $record->parent_id, 'class="chosen"'));
echo crud_field('Active',form_checkbox('active', 1, $record->active));

echo $endform;