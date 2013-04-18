<table class="table table-hover table-fixed-header">
  <thead class='header'>
		<tr>
<?php foreach ($columns as $key=>$value) { ?>		
			<th class="<?php echo (is_int($key)) ? '' : $key; ?>"><?php echo $value ?></th>
<?php } ?>
		</tr>
	</thead>
  <tbody>
