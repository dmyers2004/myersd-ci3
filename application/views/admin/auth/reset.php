<form action="/admin/auth/reset" method="post" data-validate="true">

  <fieldset>
    <legend>Reset Password</legend>
    
    <label>New Password</label>
    <input type="text" name="new" value="" placeholder="password">

    <label>Confirm New Password</label>
    <input type="text" name="new_confirm" value="" placeholder="password">


		<input type="hidden" name="hash" value="<?=$hash ?>">

    <p>
	    <button type="submit" class="btn">Submit</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="/admin/auth">Back to Login</a>
		</p>

  </fieldset>

</form>


