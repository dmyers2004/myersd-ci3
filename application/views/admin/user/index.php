<div class="header">
		<h3>Users<small class="hidden-phone">The users page is where you manage your sites users.</small></h3>
  	<a href="/admin/user/new" class="btn btn-small add-btn"><i class="icon-magic"></i> Add User</i></a>
</div>
<table class="table table-hover table-fixed-header">
  <thead class="header">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Group</th>
			<th class="txt-ac">Active</th>
			<th class="action">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td class="click_edit">
			<?=$record->username ?>
			</td>
			<td class="click_edit">
			<?=$record->email ?>
			</td>
			<td>
			<?=anchor('/admin/user/edit/'.$record->group_id, $group_options[$record->group_id]) ?>
			</td>
			<td class="txt-ac">
				<a href="/admin/user/activate/<?=$record->id ?>/" class="enum_handler" data-value="<?=$record->activated ?>" data-enum="icon-circle-blank|icon-ok-circle">
					<i class="<?=v::enum($record->activated,"icon-circle-blank|icon-ok-circle") ?>"></i>
				</a>
			</td>
			<td>
			<div class="btn-group">
			  <button class="btn">
			  	<a class="no-link-look" href="/admin/user/edit/<?=$record->id ?>">Edit</a>
			  </button>
			  <button class="btn dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			  </button>
			  	<ul class="dropdown-menu">
						<li>
							<a href="/admin/user/delete/<?=$record->id ?>" class="delete_handler">Delete</a>
						</li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
