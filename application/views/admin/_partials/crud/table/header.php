<div class="row">
  <div class="span10">
		<h3><?php echo $title ?><small><?echo $description ?></small></h3>
  </div>
  <div class="span2" style="padding-top: 8px;">
  	<?php echo anchor('/admin/'.$controller.'/new', '<i class="icon-magic"></i> Create New '.$title, 'class="btn btn-mini"') ?>
  </div>
</div>