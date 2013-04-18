<?php
echo $header;
echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true'));
echo form_hidden('id', $record->id);
echo crud_field('Name',form_input2('name',$record->name,'input-xxlarge'));
echo crud_field('Description',form_input2('description',$record->description,'input-xxlarge','Description'));
?>

<?php foreach ($all_access as $namespace => $foo) { ?>
	<fieldset>
    <legend><?php echo ucwords($namespace) ?></legend>
 	</fieldset>
	<div class="row-fluid show-grid resource">
	<?php foreach ($all_access[$namespace] as $resource) { ?>
    <div class="span4" style="margin-left: 0">
    	<label class="checkbox">
		    <?php echo form_checkbox('access['.$resource->id.']', 'true', $my_access[$resource->id], 'class="shift-group" data-group="'.$namespace.'"') ?>
		    <?php echo $resource->description ?>
	    </label>
    </div>
 	<?php } ?>
  </div>
	<?php } ?>

<?php echo $endform ?>