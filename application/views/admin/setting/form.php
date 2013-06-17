<h3 class="form-header"><?=($record->id < 0) ? 'Create' : 'Update' ?> Menubar</h3>

<?=form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
<input type="hidden" name="id" value="<?=$record->id ?>" />
	
	<div class="control-group">
		<label class="control-label" for="name">
			<strong>Name</strong>
		</label>
		<div class="controls">
		<?=form_text('option_name',$record->option_name) ?>
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
		<?=form_dropdown('option_group', $option_group, $record->option_group, 'class="selectcombobox"') ?>
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

	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		<a href="/admin/menu" class="btn">Cancel</a>
		<span class="required-txt">Required Fields are in Bold</span>
	</div>

</form>
