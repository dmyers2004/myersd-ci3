<html>
<body>
	<h1>Reset Password for <?=$identity ?></h1>
	<p><?=$forgotten_password_code ?></p>
	<p>Reset Your Password</p>
	<p>Please click this link to <?=anchor('/admin/auth/reset/'.$forgotten_password_code,'Click Here') ?></p>
	<p><a style="" href="http://www.apple.com">Apple</a></p>
</body>
</html>
