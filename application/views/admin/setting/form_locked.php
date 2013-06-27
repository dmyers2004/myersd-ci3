<h3 class="form-header"><?=($record->option_id < 0) ? 'Create' : 'Update' ?> Setting</h3>

<?=form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
<input type="hidden" name="option_id" value="<?=$record->option_id ?>" />
	
	<div class="control-group">
		<label class="control-label" for="name">
			<strong>Name</strong>
		</label>
		<div class="controls">		
			<label class="text">
			<?=$record->option_name ?>
			<?=form_hidden('option_name',$record->option_name) ?>	
			</label>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="value">
			<strong>Value</strong>
		</label>
		<div class="controls">
		<?=form_textarea('option_value', $record->option_value,'rows="3" id="textareaoption_value" class="input-xxlarge"') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="group">
			Group
		</label>
		<div class="controls">		
			<label class="text">
			<?=$record->option_group ?>
			<?=form_hidden('option_group',$record->option_group) ?>	
			</label>
		</div>	
	</div>
	
	<div class="control-group">
		<label class="control-label" for="auto_load">
			Auto Load
		</label>
		<div class="controls">
		<?=form_checkbox('auto_load', 1, $record->auto_load) ?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="type">
			Type
		</label>
		<div class="controls">
			<label class="text">
				<?=enum($record->option_type,'User|System|Module').(($record->module_name) ? ' - '.$record->module_name : '') ?>
				<?=form_hidden('option_type',$record->option_type) ?>
			</label>
		</div>
	</div>

	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		&nbsp;
		<a href="/admin/setting" class="btn">Cancel</a>
		<span class="required-txt">Required Fields are in Bold</span>
	</div>

</form>
