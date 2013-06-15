<?php 
echo $crud->login_start('/auth/forgot','Resend Activation');

echo $crud->login_field('Email*','<input type="text" id="email" name="email" value="admin@admin.com" placeholder="email">');

echo $crud->login_end();
?>
<a href="/auth">Back to Login</a>
