<h3 class="form-header"><?=($record->id < 0) ? 'Create' : 'Update' ?> Menubar</h3>

<?=form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
<input type="hidden" name="id" value="<?=$record->id ?>" />
	<?=form_hidden('old_resource', $record->resource) ?>
	<?=form_hidden('sort', $record->sort) ?>
	
	<div class="control-group">
		<label class="control-label" for="text">
			<strong>Text</strong>
		</label>
		<div class="controls">
		<?=form_text('text',$record->text,'input-small','Display') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="resource">
			<strong>Resource</strong>
		</label>
		<div class="controls">
		<?=form_text('resource',$record->resource,'input-xlarge','/nav/...') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="url">
			URL
		</label>
		<div class="controls">
		<?=form_text('url',$record->url,'input-xlarge','/') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="class">
			Class
		</label>
		<div class="controls">
		<?=form_text('class',$record->class) ?>
		</div>
	</div>
	<?php if ($record->id == -1) { ?>
	
	<div class="control-group">
		<label class="control-label" for="parent_menu">
			Parent Menu
		</label>
		<div class="controls">
			<?=form_dropdown('parent_id', $options, $record->parent_id, 'class="chosen"') ?>
		</div>
	</div>
	<?php } else { ?>
		<?=form_hidden('parent_id', $record->parent_id) ?>
	<?php } ?>
	
	<div class="control-group">
		<label class="control-label" for="active">
			Active
		</label>
		<div class="controls">
		<?=form_checkbox('active', 1, $record->active) ?>
		</div>
	</div>

	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Save</button>
		<a href="/admin/menu" class="btn">Cancel</a>
		<span class="required-txt">Required Fields are in Bold</span>
	</div>

</form>
