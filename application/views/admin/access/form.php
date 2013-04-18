<?php
echo $header;
echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true'));
echo form_hidden('id', $record->id);

echo crud_field('Description',form_input2('description',$record->description,'input-xxlarge','Description'));
echo crud_field('Resource',form_input2('resource',$record->resource,'input-xxlarge','/namespace/...'),'lowercase letters, numbers, slashes, wildcard (*)');
echo crud_field('Active',form_checkbox('active', 1, $record->active));

echo $endform;