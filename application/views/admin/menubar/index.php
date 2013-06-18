<div class="row header">
  <div class="span8">
		<h3>Menubars<small>The Menubar Page allows you to create the navigation menu for use in your layouts.</small></h3>
  </div>
  <div class="span4 txt-ar">
  	<a href="/admin/menubar/sort" class="btn btn-small"><i class="icon-sort"></i> Reorganize</i></a>
  	<a href="/admin/menubar/new" class="btn btn-small"><i class="icon-magic"></i> Add Menubar</i></a>
  </div>
</div>
<table class="table table-hover table-fixed-header">
  <thead class="header">
		<tr>
			<th>Text</th>
			<th>URL</th>
			<th class="txt-ac">Active</th>
			<th class="txt-ac">Parent</th>
			<th class="action">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td class="click_edit">
			<?=$record->text ?>
			</td>
			<td class="click_edit">
			<?=$record->url ?>
			</td>
			<td class="txt-ac">
				<a href="/admin/menubar/activate/<?=$record->id ?>/" class="enum_handler" data-value="<?=$record->active ?>" data-enum="icon-circle-blank|icon-ok-circle">
					<i class="<?=enum($record->active,"icon-circle-blank|icon-ok-circle") ?>"></i>
				</a>
			</td>
			<td class="txt-ac">
			<?=$parent_options[$record->parent_id] ?>
			</td>
			<td>
			<div class="btn-group">
			  <button class="btn">
			  	<a class="no-link-look" href="/admin/menubar/edit/<?=$record->id ?>">Edit</a>
			  </button>
			  <button class="btn dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			  </button>
			  	<ul class="dropdown-menu">
						<li>
							<a href="/admin/menubar/delete/<?=$record->id ?>" class="delete_handler">Delete</a>
						</li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
