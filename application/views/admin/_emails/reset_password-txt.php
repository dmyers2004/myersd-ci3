Hi<?php if (strlen($username) > 0) { ?> <?=$username; ?><?php } ?>,

You have changed your password.
Please, keep it in your records so you don't forget it.
<?php if (strlen($username) > 0) { ?>

Your username: <?=$username; ?>
<?php } ?>

Your email address: <?=$email; ?>

<?php /* Your new password: <?=$new_password; ?>

*/ ?>

Thank you,
The <?=$site_name; ?> Team
