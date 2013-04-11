<?php echo $header ?>
<?php echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
	<input type="hidden" name="id" value="<?php echo $record->id ?>">
	<input type="hidden" name="old_resource" value="<?php echo $record->resource ?>">

  <div class="control-group">
    <label class="control-label" for="inputText">Text</label>
    <div class="controls">
      <input type="text" class="input-small" id="inputText" placeholder="Display" name="text" value="<?php echo $record->text ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputResource">Resource</label>
    <div class="controls">
      <input type="text" id="inputResource" class="input-xlarge" placeholder="/menu/..." name="resource" value="<?php echo $record->resource ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputUrl">URL</label>
    <div class="controls">
      <input type="text" id="inputUrl" class="input-xlarge" placeholder="/" name="url" value="<?php echo $record->url ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputSort">Sort</label>
    <div class="controls">
      <input type="text" class="input-mini" id="inputSort" placeholder="0" name="sort" data-mask="float" maxlength="6" value="<?php echo $record->sort ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputClass">Class</label>
    <div class="controls">
      <input type="text" id="inputClass" placeholder="" name="class" value="<?php echo $record->class ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputConfirmPassword">Parent Menu</label>
    <div class="controls">
      <?php echo form_dropdown('parent_id', $options, $record->parent_id, 'class="chosen"') ?>
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
		<a href="/admin/<?php echo $controller ?>" class="btn">Cancel</a>
	</div>

</form>
