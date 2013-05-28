</div> <!-- /container -->
    <script src="/assets/jquery/jquery-1.9.1.min.js"></script>
		<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="/assets/js/plugins.js"></script>
		<script src="/assets/js/site.js"></script>
		<?=$page_footer ?>
		<?=$flash_msg ?>
		<div><small>
			Page rendered in <strong><?php echo $this->benchmark->elapsed_time() ?></strong> seconds.
			Environment <strong><?php echo ENVIRONMENT ?></strong>
			Memory <strong><?php echo $this->benchmark->memory_usage() ?></strong>
		</small></div>
	</body>
</html>
