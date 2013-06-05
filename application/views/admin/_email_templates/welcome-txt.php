Welcome to <?=$site_name; ?>,

Thanks for joining <?=$site_name; ?>. We listed your sign in details below. Make sure you keep them safe.
Follow this link to login on the site:

<?=site_url('/auth/login/'); ?>

<?php if (strlen($username) > 0) { ?>

Your username: <?=$username; ?>
<?php } ?>

Your email address: <?=$email; ?>

<?php /* Your password: <?=$password; ?>

*/ ?>

Have fun!
The <?=$site_name; ?> Team
