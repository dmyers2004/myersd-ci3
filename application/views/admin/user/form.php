<?php
$crud->form_start($record->id);

$crud->field('User Name',form_text('username',$record->username,'User Name') );
$crud->field('Email',form_text('email',$record->email,'Email'));
$crud->field('Password',form_password('password','', 'placeholder="Password"'));
$crud->field('Confirm Password',form_password('confirm_password','', 'placeholder="Confirm Password"'));
$crud->field('Group',form_dropdown('group_id', $group_options, $record->group_id, 'class="chosen"'));
$crud->field('Active',form_checkbox('activated', 1, $record->activated));

$crud->form_end();