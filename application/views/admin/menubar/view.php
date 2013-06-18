<label>
	<strong>Text:</strong> <?=$record->text ?>
</label>

<label>
	<strong>Resource:</strong> <?=$record->resource ?>
</label>

<label>
	<strong>URL:</strong> <?=$record->url ?>
</label>

<label>
	<strong>Is:</strong> <?=($record->active) ? 'Active' : 'Inactive' ?>
</label>

<div class="buttons">
	<a href="/admin/menubar/delete/<?=$record->id ?>" data-id="<?=$record->id ?>" class="btn btn-danger delete-button">Delete</a>
	&nbsp;
	<a href="/admin/menubar/new/<?=$record->id ?>/<?=urlencode($record->text) ?>" class="btn"><i class="icon-magic"></i> Add Child Menu</a>
	&nbsp;
	<a href="/admin/menubar/edit/<?=$record->id ?>" class="btn btn-primary">Edit</a>
</div>
