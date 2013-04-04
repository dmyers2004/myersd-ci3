<h4 class="fancy-title"><?php echo $title ?></h4>
<?php echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
	<input type="hidden" name="upriv_id" value="<?php echo $record->upriv_id ?>">

  <div class="control-group">
    <label class="control-label" for="inputDescription">Description</label>
    <div class="controls">
      <input type="text" class="input-xxlarge" id="inputDescription" placeholder="Description" name="upriv_desc" value="<?php echo $record->upriv_desc ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputResource">Resource</label>
    <div class="controls">
      <input type="text" class="input-xxlarge" id="inputResource" placeholder="/namespace/..." name="upriv_name" value="<?php echo $record->upriv_name ?>">
	    <span class="help-block">lowercase letters, numbers and slashes</span>
    </div>
  </div>

	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		<a href="/admin/access" class="btn">Cancel</a>
	</div>

</form>