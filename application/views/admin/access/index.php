<div class="row header">
  <div class="span8">
		<h3>Access<small>You can create custom permissions for different users by assigning them to groups in the Users.</small></h3>
  </div>
  <div class="span4 txt-ar">
  	<a href="/admin/access/new" class="btn btn-small"><i class="icon-magic"></i> Add Access</i></a>
  </div>
</div>
<table class="table table-hover table-fixed-header">
  <thead class="header">
		<tr>
			<th>Description</th>
			<th>Resource</th>
			<th class="txt-ac">Active</th>
			<th class="txt-ac">Type</th>
			<th class="action">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td class="click_edit">
			<?=$record->description ?>
			</td>
			<td class="click_edit">
			<?=$record->resource ?>
			</td>
			<td class="txt-ac">
				<a href="/admin/access/activate/<?=$record->id ?>/" class="enum_handler" data-value="<?=$record->active ?>" data-enum="icon-circle-blank|icon-ok-circle">
					<i class="<?=enum($record->active,"icon-circle-blank|icon-ok-circle") ?>"></i>
				</a>
			</td>
			<td class="txt-ac">
			<?=enum($record->type,'<i class="icon-user"></i>|<i class="icon-cog"></i>|<i class="icon-signin"></i>') ?>
			</td>
			<td>
			<div class="btn-group">
			  <button class="btn">
			  	<a class="no-link-look" href="/admin/access/edit/<?=$record->id ?>">Edit</a>
			  </button>
			  <button class="btn dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			  </button>
			  	<ul class="dropdown-menu">
						<li>
							<a href="/admin/access/delete/<?=$record->id ?>" class="delete_handler">Delete</a>
						</li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<h6><i class="icon-user"></i> User Entered <img width=32 height=0><i class="icon-cog"></i> System Entered <img width=32 height=0><i class="icon-signin"></i> Module Entered</h6>
