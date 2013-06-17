<div class="row header">
  <div class="span8">
		<h3>Menubars<small>The Menubar Page allows you to create the navigation menu for use in your layouts.</small></h3>
  </div>
  <div class="span4 txt-ar">
  	<a href="/admin/menu/new" class="btn btn-small"><i class="icon-magic"></i> Add Menubar</i></a>
  </div>
</div>
<table class="table table-hover table-fixed-header">
  <thead class="header">
		<tr>
			<th>Name</th>
			<th>Value</th>
			<th>Group</th>
			<th class="txt-ac">Autoload</th>
			<th class="action">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($records as $record) { ?>
		<tr>
			<td class="click_edit">
			<?=$record->option_name ?>
			</td>
			<td class="click_edit">
			<?=shorten(htmlspecialchars($record->option_value),64) ?>
			</td>
			<td class="click_edit">
			<?=$record->option_group ?>
			</td>
			<td class="txt-ac">
				<a href="/admin/menu/activate/<?=$record->id ?>/" class="enum_handler" data-value="<?=$record->auto_load ?>" data-enum="icon-circle-blank|icon-ok-circle">
					<i class="<?=enum($record->auto_load,"icon-circle-blank|icon-ok-circle") ?>"></i>
				</a>
			</td>
			<td>
			<div class="btn-group">
			  <button class="btn">
			  	<a class="no-link-look" href="/admin/menu/edit/<?=$record->id ?>">Edit</a>
			  </button>
			  <button class="btn dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			  </button>
			  	<ul class="dropdown-menu">
						<li>
							<a href="/admin/menu/delete/<?=$record->id ?>" class="delete_handler">Delete</a>
						</li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
