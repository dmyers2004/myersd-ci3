<?php echo $header ?>
<?php echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
	<input type="hidden" name="option_id" value="<?php echo $record->option_id ?>">

  <div class="control-group">
    <label class="control-label" for="inputName">Name</label>
    <div class="controls">
      <input type="text" class="" id="inputName" placeholder="" name="option_name" value="<?php echo $record->option_name ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputValue">Value</label>
    <div class="controls">
    	<textarea rows="3" id="inputValue" class="input-xxlarge" name="option_value"><?php echo $record->option_value ?></textarea>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputGroup">Group</label>
    <div class="controls">
      <?php echo form_dropdown('option_group', $option_group, $record->option_group, 'class="selectcombobox"') ?>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <label class="checkbox" for="inputActivate">
				<?php echo form_checkbox('auto_load', 1, $record->auto_load) ?> Auto Load
			</label>
    </div>
  </div>

	<div class="form-actions">
		<a href="/admin/<?php echo $controller ?>" class="btn">Cancel</a>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>

</form>
