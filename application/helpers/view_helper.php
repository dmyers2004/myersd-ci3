<?php 

function flipflop($input,$string) {
	list($one,$zero) = explode('|',$string);
	return ($input) ? $one : $zero;
}