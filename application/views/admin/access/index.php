<?php echo $header ?>

<table class="table table-hover table-fixed-header">
  <thead class='header'>
		<tr>
			<th>Description</th>
			<th>Resource</th>
			<th class="txt-ac">Active</th>
			<th>Action</th>
		</tr>
	</thead>
  <tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td><?php echo $record->upriv_desc ?></td>
			<td><?php echo $record->upriv_name ?></td>
			<td class="txt-ac">
				<a href="/admin/<?php echo $controller ?>/activate/<?php echo $record->uacc_id ?>/<?php echo ($record->uacc_active) ? 0 : 1 ?>" class="activate_handler"><i style="font-size: 120%" class="<?php echo ($record->uacc_active) ? 'icon-ok-circle' : 'icon-circle-blank' ?>"></i></a>
			</td>
			<td>
				<div class="btn-group">
				  <button class="btn"><a class="no-link-look" href="/admin/access/edit/<?php echo $record->upriv_id ?>">Edit</a></button>
				  <button class="btn dropdown-toggle" data-toggle="dropdown">
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				    <li><a href="/admin/<?php echo $controller ?>/delete/<?php echo $record->upriv_id ?>" class="delete_handler">Delete</a></li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
