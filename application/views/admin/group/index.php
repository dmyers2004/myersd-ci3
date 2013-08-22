<div class="header">
	<h3>Groups<small class="hidden-phone">Users can be placed into groups to manage permissions.</small></h3>
	<a href="/admin/group/new" class="btn btn-small add-btn"><i class="icon-magic"></i> Add Group</i></a>
</div>
<table class="table table-hover table-fixed-header">
  <thead>
		<tr>
			<th>Group Name</th>
			<th>Description</th>
			<th class="action">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td class="click_edit">
			<?=$record->name ?>
			</td>
			<td class="click_edit">
			<?=$record->description ?>
			</td>
			<td>
			<div class="btn-group">
			  <button class="btn">
			  	<a class="no-link-look" href="/admin/group/edit/<?=$record->id ?>">Edit</a>
			  </button>
			  <button class="btn dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			  </button>
			  	<ul class="dropdown-menu">
						<li>
							<a href="/admin/group/delete/<?=$record->id ?>" class="delete_handler">Delete</a>
						</li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
