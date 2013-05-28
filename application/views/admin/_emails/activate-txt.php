Welcome to <?=$site_name; ?>,

Thanks for joining <?=$site_name; ?>. We listed your sign in details below, make sure you keep them safe.
To verify your email address, please follow this link:

<?=site_url('/auth/activate/'.$user_id.'/'.$new_email_key); ?>

Please verify your email within <?=$activation_period; ?> hours, otherwise your registration will become invalid and you will have to register again.
<?php if (strlen($username) > 0) { ?>

Your username: <?=$username; ?>
<?php } ?>

Your email address: <?=$email; ?>
<?php if (isset($password)) { /* ?>

Your password: <?=$password; ?>
<?php */ } ?>

Have fun!
The <?=$site_name; ?> Team
