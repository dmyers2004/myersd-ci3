<h3 class="form-header"><?=($record->id < 0) ? 'Create' : 'Update' ?> Access</h3>

<?=form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
<input type="hidden" name="id" value="<?=$record->id ?>" />
	
	<div class="control-group">
		<label class="control-label" for="description">
			<strong>Description</strong>
		</label>
		<div class="controls">
		<?=form_text('description',$record->description,'input-xxlarge','Description') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="resource">
			<strong>Resource</strong>
		</label>
		<div class="controls">
		<?=form_text('resource',$record->resource,'input-xxlarge','/namespace/...') ?>
		<span class="help-block">lowercase letters, numbers, slashes, wildcard (*)</span>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="active">
			Active
		</label>
		<div class="controls">
		<?=form_checkbox('active', 1, $record->active) ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="type">
			Type
		</label>
		<div class="controls">
		<label class="text">
			<?=enum($record->type,'User|System|Module').(($record->module_name) ? ' - '.$record->module_name : '') ?>
			<?=form_hidden('type',$record->type) ?>
		</label>
		</div>
	</div>

	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		&nbsp;
		<a href="/admin/access" class="btn">Cancel</a>
		<span class="required-txt">Required Fields are in Bold</span>
	</div>

</form>
