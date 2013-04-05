<h3><?php echo $title ?><small><?echo $description ?></small></h3>
<?php echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
	<input type="hidden" name="id" value="<?php echo $record->id ?>">

  <div class="control-group">
    <label class="control-label" for="inputFirstname">User Name</label>
    <div class="controls">
      <input type="text" id="inputFirstname" placeholder="First Name" name="cd_first_name" value="<?php echo $record->username ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" id="inputEmail" placeholder="Email" name="uacc_email" value="<?php echo $record->email ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="Password" name="password">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputConfirmPassword">Confirm Password</label>
    <div class="controls">
      <input type="password" id="inputConfirmPassword" name="confirm_password" placeholder="Confirm Password">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputConfirmPassword">Group</label>
    <div class="controls">
      <?php echo form_dropdown('group_id', $group_options, $record->group_id, 'class="chosen"') ?>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <label class="checkbox" for="inputActivate">
				<?php echo form_checkbox('activated', 1, $record->activated) ?> Active
			</label>
    </div>
  </div>

	<div class="form-actions">
		<a href="/admin/<?php echo $controller ?>" class="btn">Cancel</a>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>

</form>