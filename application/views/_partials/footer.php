		<div class="stats">
			Page rendered in <strong><?=$this->benchmark->elapsed_time() ?></strong> seconds.
			Environment <strong><?=ENVIRONMENT ?></strong>
			Memory <strong><?=$this->benchmark->memory_usage() ?></strong>
			CodeIgniter Version <strong><?=CI_VERSION ?></strong>
		</div>
		<?=$page_footer ?>
		<?=$page_js ?>
		<?=$flash_msg ?>
		<!-- <?=$route ?> -->
	</body>
</html>