<h4 class="fancy-title"><?php echo $title ?></h4>
<?php echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
	<input type="hidden" name="id" value="<?php echo $record->id ?>">

  <div class="control-group">
    <label class="control-label" for="inputDescription">Description</label>
    <div class="controls">
      <input type="text" class="input-xxlarge" id="inputDescription" placeholder="Description" name="description" value="<?php echo $record->description ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputResource">Resource</label>
    <div class="controls">
      <input type="text" class="input-xxlarge" id="inputResource" placeholder="/namespace/..." name="resource" value="<?php echo $record->resource ?>">
	    <span class="help-block">lowercase letters, numbers, slashes, wildcard (*)</span>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <label class="checkbox" for="inputActivate">
				<?php echo form_checkbox('active', 1, $record->active) ?> Active
			</label>
    </div>
  </div>

	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		<a href="/admin/access" class="btn">Cancel</a>
	</div>

</form>