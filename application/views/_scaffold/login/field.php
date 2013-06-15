	<label for="<?=between('id="','"',$arg2) ?>">
		<?=(substr($arg1,-1) == '*') ? '<strong>'.substr($arg1,0,-1).'</strong>' : $arg1 ?>
	</label>

	<?=$arg2 ?><?=($arg3) ? '<span class="help-block">'.$arg3.'</span>' : '' ?>
