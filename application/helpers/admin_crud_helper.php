<?php 
function form_input2($name,$value,$class='',$placeholder='',$extra='') {
	return '<input type="text" id="input'.$name.'" name="'.$name.'" class="'.$class.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$extra.'>';
}

function crud_field($description,$element,$help='') {
	$help = ($help) ? '<span class="help-block">'.$help.'</span>' : '';
	$id = between('id="','"',$element);
	$label_class = between('type="','"',$element);
	
	switch ($label_class) {
		case 'checkbox':
			return get_instance()->load->view('admin/_partials/crud_checkbox',array('id'=>$id,'description'=>$description,'element'=>$element,'help'=>$help));
		break;
		default:
			return get_instance()->load->view('admin/_partials/crud_input',array('id'=>$id,'description'=>$description,'element'=>$element,'help'=>$help));
	}
}

function crud_table_start($columns=array()) {
	return get_instance()->load->view('admin/_partials/crud_table_start',array('columns'=>$columns));
}

function crud_table_end($columns=array()) {
	return get_instance()->load->view('admin/_partials/crud_table_end',array('columns'=>$columns));
}

function crud_table_active() {}
function crud_table_end_action() {}
function crud_table_end() {}
function crud_table_start_action() {}
function crud_table_start() {}
function crud_table_row() {}
function crud_table_action_delete() {}
function crud_table_action() {}

