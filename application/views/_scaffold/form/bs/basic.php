<div class="control-group">
	<label class="control-label" for="<?=between('id="','"',$arg2) ?>">
		<?=$arg1 ?>
	</label>
	<div class="controls">
		<?=$arg2 ?><?=($arg3) ? '<span class="help-block">'.$arg3.'</span>' : '' ?>
	</div>
</div>
