<?php 

function enum($input,$string) {
	$enum = explode('|',$string);
	echo $enum[(int)$input];
}