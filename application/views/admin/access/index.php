<?php echo $header ?>

<table class="table table-hover table-fixed-header">
  <thead class='header'>
		<tr>
			<th>Description</th>
			<th>Resource</th>
			<th>Action</th>
		</tr>
	</thead>
  <tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td><?php echo $record->upriv_desc ?></td>
			<td><?php echo $record->upriv_name ?></td>
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
