<?=load('_partials/start') ?>
<?=load('_partials/header') ?>
<?=load('_partials/body') ?>
<?=load('_partials/nav') ?>

<div class="container">
	<div class="row">
		<?php echo ($page_lspan) ? load('_partials/left') : '' ?>
		<?php echo ($page_cspan) ? load('_partials/center') : '' ?>
		<?php echo ($page_rspan) ? load('_partials/right') : '' ?>
	</div>
</div>

<?=load('_partials/status') ?>
<?=load('_partials/end') ?>
