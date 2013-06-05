<?php if ($live) { ?>
	<p>Your account is now live!</p>
	<p><a href="/admin/auth">Login</a></p>
<? } else { ?>
	<p>Activation Error</p>
	<p><a href="/">Home Page</a></p>
<? }?>