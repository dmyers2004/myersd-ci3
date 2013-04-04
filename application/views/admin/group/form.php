<h4 class="fancy-title"><?php echo $title ?></h4>
<?php echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
	<input type="hidden" name="ugrp_id" value="<?php echo $record->ugrp_id ?>">

  <div class="control-group">
    <label class="control-label" for="inputName">Name</label>
    <div class="controls">
      <input type="text" id="inputName" placeholder="Name" name="ugrp_name" value="<?php echo $record->ugrp_name ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputDescription">Description</label>
    <div class="controls">
      <input type="text" class="input-xxlarge" id="inputDescription" placeholder="Description" name="ugrp_desc" value="<?php echo $record->ugrp_desc ?>">
    </div>
  </div>

	<?php foreach ($all_access as $namespace => $foo) { ?>
		<fieldset>
	    <legend><?php echo ucwords($namespace) ?></legend>
	 	</fieldset>
		<div class="row-fluid show-grid resource">
		<?php foreach ($all_access[$namespace] as $resource) { ?>
	    <div class="span4" style="margin-left: 0">
	    	<label class="checkbox">
			    <input type="checkbox" class="shift-group" data-group="<?php echo $namespace ?>" name="uprivs[<?php echo $resource->upriv_id ?>]" value="true" <?php echo (($my_access[$resource->upriv_id]) ? 'checked="checked"' : ''  ) ?>>
			    <?php echo $resource->upriv_desc ?>
		    </label>
	    </div>
   	<?php } ?>
	  </div>
 	<?php } ?>

	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		<a href="/admin/group" class="btn">Cancel</a>
	</div>

</form>