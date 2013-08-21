<h3 class="form-header"><?=$section_title ?></h3>

<?=form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
<input type="hidden" name="id" value="<?=$record->id ?>" />
	
	<div class="control-group">
		<label class="control-label" for="user_name">
			<strong>User Name</strong>
		</label>
		<div class="controls">
		<?=form_text('username',$record->username,'User Name') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="email">
			<strong>Email</strong>
		</label>
		<div class="controls">
		<?=form_text('email',$record->email,'Email') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="password">
			<strong>Password</strong>
		</label>
		<div class="controls">
		<?=form_password('password','', 'placeholder="Password"') ?>
		<span class="help-block"><?=$password_format_copy ?></span>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="confirm_password">
			<strong>Confirm Password</strong>
		</label>
		<div class="controls">
		<?=form_password('confirm_password','', 'placeholder="Confirm Password"') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="group">
			Group
		</label>
		<div class="controls">
		<?=form_dropdown('group_id', $group_options, $record->group_id, 'class="select2"') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="active">
			Active
		</label>
		<div class="controls">
		<?=form_checkbox('activated', 1, $record->activated) ?>
		</div>
	</div>

	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		&nbsp;
		<a href="/admin/user" class="btn">Cancel</a>
		<span class="required-txt">Required Fields are in Bold</span>
	</div>

</form>
