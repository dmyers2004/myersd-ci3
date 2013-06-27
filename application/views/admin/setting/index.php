<div class="header">
	<h3>Settings<small class="hidden-phone">The settings page is where all module settings are located.</small></h3>
	<a href="/admin/setting/new" class="btn btn-small add-btn"><i class="icon-magic"></i> Add Setting</i></a>
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
				<a href="/admin/setting/activate/<?=$record->option_id ?>/" class="enum_handler" data-value="<?=$record->auto_load ?>" data-enum="icon-circle-blank|icon-ok-circle">
					<i class="<?=enum($record->auto_load,"icon-circle-blank|icon-ok-circle") ?>"></i>
				</a>
			</td>
			<td>
			<div class="btn-group">
			  <button class="btn">
			  	<a class="no-link-look" href="/admin/setting/edit/<?=$record->option_id ?>">Edit</a>
			  </button>
			  <button class="btn dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			  </button>
			  	<ul class="dropdown-menu">
						<li>
							<a href="/admin/setting/delete/<?=$record->option_id ?>" class="delete_handler">Delete</a>
						</li>
				  </ul>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
