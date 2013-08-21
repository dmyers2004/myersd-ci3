<h3 class="form-header"><?=$section_title ?></h3>

<?=form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
<input type="hidden" name="id" value="<?=$record->id ?>" />
	
	<div class="control-group">
		<label class="control-label" for="name">
			<strong>Name</strong>
		</label>
		<div class="controls">
<?php if ($record->type == 0) { ?>		
		<?=form_text('name',$record->name) ?>
<?php } else { ?>
		<label class="text">
		<?=$record->name ?>
		<?=form_hidden('name',$record->name) ?>	
		</label>
<?php } ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="value">
			<strong>Value</strong>
		</label>
		<div class="controls">
		<?=form_textarea('value', $record->value,'rows="3" id="textareavalue" class="input-xxlarge"') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="group">
			Group
		</label>
		<div class="controls">
<?php if ($record->type == 0) { ?>		
			<?=form_dropdown('group', $group, $record->group, 'class="combobox"') ?>
<?php } else { ?>
			<label class="text">
			<?=$record->group ?>
			<?=form_hidden('group',$record->group) ?>	
			</label>
<?php } ?>
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
			<?=$Enum($record->type,'User|System|Module').(($record->module_name) ? ' - '.$record->module_name : '') ?>
			<?=form_hidden('type',$record->type) ?>
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
