<?php
$crud->form_start($record->id);

$crud->form_bs_basic('User Name',form_text('username',$record->username,'User Name') );
$crud->form_bs_basic('Email',form_text('email',$record->email,'Email'));
$crud->form_bs_basic('Password',form_password('password','', 'placeholder="Password"'));
$crud->form_bs_basic('Confirm Password',form_password('confirm_password','', 'placeholder="Confirm Password"'));
$crud->form_bs_basic('Group',form_dropdown('group_id', $group_options, $record->group_id, 'class="chosen"'));
$crud->form_bs_basic('Active',form_checkbox('activated', 1, $record->activated));

$crud->form_end();