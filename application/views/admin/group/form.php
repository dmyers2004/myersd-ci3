<h3 class="form-header"><?=($record->id < 0) ? 'Create' : 'Update' ?> Group</h3>

<?=form_open($action,array('class'=>'form-horizontal','data-validate'=>'true')) ?>
<input type="hidden" name="id" value="<?=$record->id ?>" />
	
	<div class="control-group">
		<label class="control-label" for="name">
			<strong>Name</strong>
		</label>
		<div class="controls">
		<?=form_text('name',$record->name,'input-xxlarge') ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="description">
			Description
		</label>
		<div class="controls">
		<?=form_text('description',$record->description,'input-xxlarge','Description') ?>
		</div>
	</div>
	<?php	if (count($users) > 0) { ?>
		<h4>Group Members</h4>
		<ul class="user-list">
		<?php foreach ($users as $user) { ?>
			<li><a href="/admin/user/edit/<?=$user->id ?>"><?=$user->username ?></a></li>	
		<? } ?>
		</ul>
	<? } ?>
	
	<h4 class="group-access">Group Access <small>separated by namespace,</small></h4>

	<ul class="nav nav-tabs" id="access-tabs">
	<?php foreach ($all_access as $namespace => $foo) { ?>
		<li><a href="#<?=$namespace ?>"><?=$namespace ?></a></li>
	<?php } ?>		
	</ul>

	<div class="tab-content">
	<?php foreach ($all_access as $namespace => $foo) { ?>
			<div class="tab-pane" id="<?=url_title($namespace) ?>">
			<?php foreach ($all_access[$namespace] as $resource) { ?>
			  <div class="span4" style="margin-left: 0">
			  	<label class="checkbox">
				    <?=form_checkbox('access['.$resource->id.']', 'true', $my_access[$resource->id], 'class="shift-group" data-group="'.url_title($namespace).'"') ?>
				    <?=$resource->description ?>
			    </label>
			  </div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>

	<div class="form-actions">
		<a href="<?=$controller_path ?>" class="btn">Cancel</a>
		&nbsp;
		<button type="submit" class="btn btn-primary">Save</button>
		<span class="required-txt">Required Fields are in Bold</span>
	</div>

</form>