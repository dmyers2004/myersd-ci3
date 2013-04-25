<table class="table table-hover table-fixed-header">
  <thead class='header'>
		<tr>
<?php foreach ($arg1 as $key=>$value) { ?>		
			<th class="<?php echo (is_int($key)) ? $key : $value; ?>"><?php echo (is_int($key)) ? $value : $key; ?></th>
<?php } ?>
			<th style="width: 130px">Action</th>	
		</tr>
	</thead>
  <tbody>
