		<?=$page_footer ?>
		<?=$flash_msg ?>
		<?php if ($no_stats !== true) { ?>
		<div class="stats">
			Page rendered in <strong><?php echo $this->benchmark->elapsed_time() ?></strong> seconds.
			Environment <strong><?php echo ENVIRONMENT ?></strong>
			Memory <strong><?php echo $this->benchmark->memory_usage() ?></strong>
		</div>
		<?php } ?>
	</body>
</html>