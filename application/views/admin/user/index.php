<?php echo $header ?>
<table class="table table-hover table-fixed-header">
	<thead class="header">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Group</th>
			<th class="txt-ac">Active</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td><?php echo $record->username ?></td>
			<td><?php echo $record->email ?></td>
			<td><?php echo anchor('/admin/group/edit/'.$record->group_id, $group_options[$record->group_id]) ?></td>
			<td class="txt-ac">
				<a href="/admin/<?php echo $controller ?>/activate/<?php echo $record->id ?>/<?php echo (int)$record->activated ?>" class="activate_handler"><i class="<?php enum($record->activated,'icon-ok-circle|icon-circle-blank') ?>"></i></a>
			</td>
			<td>
				<div class="btn-group">
				  <button class="btn"><a class="no-link-look" href="/admin/<?php echo $controller ?>/edit/<?php echo $record->id ?>">Edit</a></button>
				  <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
				  <ul class="dropdown-menu">
				    <li><a href="/admin/<?php echo $controller ?>/activate/<?php echo $record->id ?>/<?php echo (int)$record->activated ?>" class="activate_handler"><?php enum($record->activated,'Deactivate|Activate') ?></a></li>
				    <li><a href="/admin/<?php echo $controller ?>/delete/<?php echo $record->id ?>" class="delete_handler">Delete</a></li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
