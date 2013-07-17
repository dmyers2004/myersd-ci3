<h3 class="form-header"><?=($record->id < 0) ? 'Create' : 'Update' ?> User</h3>

<?=form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
<input type="hidden" name="id" value="<?=$record->id ?>" />
	
	<div class="control-group">
		<label class="control-label" for="username">
			<strong>User Name</strong>
		</label>
		<div class="controls">
		<?=form_text(sfn('users.username.id.'.$record->id),$record->username,'User Name') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="email">
			<strong>Email</strong>
		</label>
		<div class="controls">
		<?=form_text(sfn('users.email.id.'.$record->id),$record->email,'Email') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="password">
			<strong>Password</strong>
		</label>
		<div class="controls">
		<?=form_password(sfn('users.password.id.'.$record->id),'xyz', 'placeholder="Password"') ?>
		</div>
	</div>
<?=sf_finished() ?>
	
	<div class="control-group">
		<label class="control-label" for="confirm_password">
			<strong>Confirm Password</strong>
		</label>
		<div class="controls">
		<?=form_password(sfn('users.confirm_password.id.'.$record->id),'xyz', 'placeholder="Confirm Password"') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="group">
			Group
		</label>
		<div class="controls">
		<?=form_dropdown(sfn('users.group_id.id.'.$record->id), $group_options, $record->group_id, 'class="select2"') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="active">
			Active
		</label>
		<div class="controls">
		<?=form_checkbox(sfn('users.activated.id.'.$record->id), 1, $record->activated) ?>
		</div>
	</div>
<?=sf_finished() ?>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		&nbsp;
		<a href="/admin/user" class="btn">Cancel</a>
		<span class="required-txt">Required Fields are in Bold</span>
	</div>

</form>
