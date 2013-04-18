<?php echo $header ?>

<table class="table table-hover table-fixed-header">
  <thead class="header">
		<tr>
			<th>Name</th>
			<th>Value</th>
			<th>Group</th>
			<th class="txt-ac">Autoload</th>
			<th>Action</th>
		</tr>
	</thead>
  <tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td><?php echo $record->option_name ?></td>
			<td><?php echo substr(htmlspecialchars($record->option_value),0,64) ?></td>
			<td><?php echo $record->option_group ?></td>
			<td class="txt-ac">
				<a href="/admin/<?php echo $controller ?>/autoload/<?php echo $record->option_id ?>/<?php echo (int)$record->auto_load ?>" class="activate_handler"><i class="<?php enum($record->auto_load,'icon-ok-circle|icon-circle-blank') ?>"></i></a>
			</td>
			<td>
				<div class="btn-group">
				  <button class="btn">
				  	<a class="no-link-look" href="/admin/<?php echo $controller ?>/edit/<?php echo $record->option_id ?>">Edit</a>
				  </button>
				  <button class="btn dropdown-toggle" data-toggle="dropdown">
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				    <li><a href="/admin/<?php echo $controller ?>/autoload/<?php echo $record->option_id ?>/<?php echo (int)$record->auto_load ?>" class="activate_handler"><?php enum($record->auto_load,'Deactivate|Activate') ?></a></li>
				    <li><a href="/admin/<?php echo $controller ?>/delete/<?php echo $record->option_id ?>" class="delete_handler">Delete</a></li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
