<h3><?php echo $title ?><small><?echo $description ?></small></h3>
<?php echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
	<input type="hidden" name="uacc_id" value="<?php echo $record->uacc_id ?>">

  <div class="control-group">
    <label class="control-label" for="inputFirstname">First Name</label>
    <div class="controls">
      <input type="text" id="inputFirstname" placeholder="First Name" name="cd_first_name" value="<?php echo $record->cd_first_name ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputLastname">Last Name</label>
    <div class="controls">
      <input type="text" id="inputLastname" placeholder="Last Name" name="cd_last_name" value="<?php echo $record->cd_last_name ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" id="inputEmail" placeholder="Email" name="uacc_email" value="<?php echo $record->uacc_email ?>">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="Password" name="uacc_password">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputConfirmPassword">Confirm Password</label>
    <div class="controls">
      <input type="password" id="inputConfirmPassword" name="uacc_password_confirm" placeholder="Confirm Password">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputConfirmPassword">Group</label>
    <div class="controls">
      <?php echo form_dropdown('uacc_group_fk', $group_options, $record->uacc_group_fk, 'class="chosen"') ?>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <label class="checkbox" for="inputActivate">
				<?php echo form_checkbox('uacc_active', 1, $record->uacc_active) ?> Active
			</label>
    </div>
  </div>

	<div class="form-actions">
		<a href="/admin/<?php echo $controller ?>" class="btn">Cancel</a>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>

</form>