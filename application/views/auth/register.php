<?php 
echo $crud->login_start('/auth/register','Register');

echo $crud->login_field('User Name*','<input type="text" id="username" name="username" value="Joe Doe" placeholder="user name">');

echo $crud->login_field('Email*','<input type="text" id="email" name="email" value="admin@admin.com" placeholder="email">');

echo $crud->login_field('Password*','<input type="password" id="password" name="password" value="password" placeholder="password">');

echo $crud->login_field('Confirm Password*','<input type="password" id="confirm_password" name="confirm_password" value="password" placeholder="password">');

echo $crud->login_end();
?>
<a href="/auth">Back to Login</a>
