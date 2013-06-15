<?php 
echo $crud->login_start('/auth/login','Login');

echo $crud->login_field('Email*','<input type="text" id="email" name="email" value="admin@admin.com" placeholder="email">');

echo $crud->login_field('Password*','<input type="password" id="password" name="password" value="password" placeholder="password">');

echo $crud->login_checkbox('remember','Remember Me',$rememberme);

echo $crud->login_end();
?>
<a href="/auth/register">Register</a>
<img width=32 height=0>
<a href="/auth/forgot">Forgot Password</a>

