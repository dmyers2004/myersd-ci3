<?php echo $header ?>

<table class="table table-hover table-fixed-header">
  <thead class='header'>
		<tr>
			<th>Text</th>
			<th>URL</th>
			<th>Resource</th>
			<th class="txt-ac">Sort</th>
			<th class="txt-ac">Active</th>
			<th class="txt-ac">Parent</th>
			<th>Action</th>
		</tr>
	</thead>
  <tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td><?php echo $record->text ?></td>
			<td><?php echo $record->url ?></td>
			<td><?php echo $record->resource ?></td>
			<td class="txt-ac"><?php echo $record->sort ?></td>
			<td class="txt-ac">
				<a href="/admin/<?php echo $controller ?>/activate/<?php echo $record->id ?>/<?php echo ($record->active) ? 0 : 1 ?>" class="activate_handler"><i style="font-size: 120%" class="<?php echo ($record->active) ? 'icon-ok-circle' : 'icon-circle-blank' ?>"></i></a>
			</td>
			<td class="txt-ac"><?php echo ($record->parent_id == 0) ? '<i style="font-size: 120%" class="icon-upload"></i>' : $parent_options[$record->parent_id] ?></td>
			<td>
				<div class="btn-group">
				  <button class="btn">
				  	<a class="no-link-look" href="/admin/<?php echo $controller ?>/edit/<?php echo $record->id ?>">Edit</a>
				  </button>
				  <button class="btn dropdown-toggle" data-toggle="dropdown">
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				    <li><a href="/admin/<?php echo $controller ?>/activate/<?php echo $record->id ?>/<?php echo ($record->active) ? 0 : 1 ?>" class="activate_handler"><?php echo ($record->active) ? 'Deactivate' : 'Activate' ?></a></li>
				    <li><a href="/admin/<?php echo $controller ?>/sort/up/<?php echo $record->id ?>" class="ajax-href" >Sort Up</a></li>
				    <li><a href="/admin/<?php echo $controller ?>/sort/down/<?php echo $record->id ?>" class="ajax-href" >Sort Down</a></li>
				    <li><a href="/admin/<?php echo $controller ?>/delete/<?php echo $record->id ?>" class="delete_handler">Delete</a></li>
				  </ul>
				</div>
			</td>			
		</tr>
	<?php } ?>
	</tbody>
</table>
