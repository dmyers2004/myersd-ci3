<h4 class="fancy-title"><?php echo $title ?></h4>
<?php echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
	<input type="hidden" name="id" value="<?php echo $record->id ?>">

  <div class="control-group">
    <label class="control-label" for="inputName">Name</label>
    <div class="controls">
      <input type="text" id="inputName" placeholder="Name" name="name" value="<?php echo $record->name ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputDescription">Description</label>
    <div class="controls">
      <input type="text" class="input-xxlarge" id="inputDescription" placeholder="Description" name="description" value="<?php echo $record->description ?>">
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
			    <input type="checkbox" class="shift-group" data-group="<?php echo $namespace ?>" name="access[<?php echo $resource->id ?>]" value="true" <?php echo (($my_access[$resource->id]) ? 'checked="checked"' : ''  ) ?>>
			    <?php echo $resource->description ?>
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