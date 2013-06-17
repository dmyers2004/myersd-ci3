<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/* make built in form_input better! */
function form_text($name,$value='',$class='',$placeholder='',$extra='')
{
	return '<input type="text" id="input_'.$name.'" name="'.$name.'" class="'.$class.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$extra.'>';
}
