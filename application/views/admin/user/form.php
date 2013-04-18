<?php
echo $header;
echo form_open($action,array('class'=>'form-horizontal','data-validate'=>'true'));
echo form_hidden('id', $record->id);

echo crud_field('User Name',form_input2('username',$record->username,'User Name') );
echo crud_field('Email',form_input2('email',$record->email,'Email'));
echo crud_field('Password',form_password('password','', 'placeholder="Password"'));
echo crud_field('Confirm Password',form_password('confirm_password','', 'placeholder="Confirm Password"'));
echo crud_field('Group',form_dropdown('group_id', $group_options, $record->group_id, 'class="chosen"'));
echo crud_field('Active',form_checkbox('activated', 1, $record->activated));

echo $endform;
