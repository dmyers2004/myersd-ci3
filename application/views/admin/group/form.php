<?php
$crud->form_start($record->id);

$crud->field('Name',form_text('name',$record->name,'input-xxlarge'));
$crud->field('Description',form_text('description',$record->description,'input-xxlarge','Description'));

foreach ($all_access as $namespace => $foo) {
?>
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
	<?php
}

$crud->form_end();
