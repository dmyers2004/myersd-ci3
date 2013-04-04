<html>
<body>
	<h1>Reset Password for <?php echo $identity ?></h1>
	<p><?php echo $forgotten_password_code ?></p>
	<p>Reset Your Password</p>
	<p>Please click this link to <?php echo anchor('/admin/auth/reset/'.$forgotten_password_code,'Click Here') ?></p>
	<p><a style="" href="http://www.apple.com">Apple</a></p>
</body>
</html>
