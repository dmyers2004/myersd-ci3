</div> <!-- /container -->
		<?=$page_footer ?>
		<?=$flash_msg ?>
		<div class="stats">
			Page rendered in <strong><?php echo $this->benchmark->elapsed_time() ?></strong> seconds.
			Environment <strong><?php echo ENVIRONMENT ?></strong>
			Memory <strong><?php echo $this->benchmark->memory_usage() ?></strong>
		</div>
		<div>
		<pre>
		<?php print_r($_SESSION) ?>
		</div>
	</body>
</html>