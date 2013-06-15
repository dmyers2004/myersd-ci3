<?php 
echo $crud->login_start('/auth/reset','Reset Password');

echo $crud->login_field('Password*','<input type="password" id="password" name="password" value="password" placeholder="password">');

echo $crud->login_field('Confirm Password*','<input type="password" id="confirm_password" name="confirm_password" value="password" placeholder="password">');

echo $crud->login_end();
?>
<a href="/auth">Back to Login</a>
