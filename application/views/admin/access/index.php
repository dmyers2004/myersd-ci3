<div class="header">
	<h3>Access<small class="hidden-phone">You can create custom permissions for different users by assigning them to groups in the Users.</small></h3>
	<a href="/admin/access/new" class="btn btn-small add-btn"><i class="icon-magic"></i> Add Access</i></a>
</div>

<ul class="nav nav-tabs" id="access-tabs">
<?php foreach ($all_records as $namespace => $foo) { ?>
	<li><a href="#<?=url_title($namespace) ?>"><?=$namespace ?></a></li>
<?php } ?>		
</ul>

<div class="tab-content">
<?php foreach ($all_records as $namespace => $records) { ?>
		<div class="tab-pane" id="<?=url_title($namespace) ?>">
			<table class="table table-hover">
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
						<td<? if ($record->type == 0) { ?> class="click_edit"<? } ?>>
						<?=$record->description ?>
						</td>
						<td<? if ($record->type == 0) { ?> class="click_edit"<? } ?>>
						<?=$record->resource ?>
						</td>
						<td class="txt-ac">
							<a href="/admin/access/activate/<?=$record->id ?>/" class="enum_handler" data-value="<?=$record->active ?>" data-enum="icon-circle-blank|icon-ok-circle">
								<i class="<?=$Enum($record->active,"icon-circle-blank|icon-ok-circle") ?>"></i>
							</a>
						</td>
						<td class="txt-ac">
						<?=$Enum($record->type,'<i class="icon-user"></i>|<i class="icon-cog"></i>|<i class="icon-signin"  data-toggle="tooltip" data-original-title="'.$record->module_name.'"></i>') ?>
						</td>
						<td>
			<?php if ($record->type == 0) { ?>						
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
			<?php } ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>

		</div>
	<?php } ?>
</div>

<h6><i class="icon-user"></i> User Entered <img width=32 height=0><i class="icon-cog"></i> System Entered <img width=32 height=0><i class="icon-signin"></i> Module Entered</h6>



