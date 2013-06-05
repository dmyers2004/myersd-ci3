<form action="/admin/auth/reset" method="post" data-validate="true">

  <fieldset>
    <legend>Reset Password</legend>

    <div class="password control-group">
	    <label>New Password</label>
	    <input type="text" name="new" value="" placeholder="password">
		</div>

    <div class="password control-group">
	    <label>Confirm New Password</label>
	    <input type="text" name="new_confirm" value="" placeholder="password">
		</div>

		<input type="hidden" name="hash" value="<?=$hash ?>">

    <p>
	    <button type="submit" class="btn">Submit</button>
	    <img src="" width="64" height="1">
	    <a href="/admin/auth">Back to Login</a>
		</p>

  </fieldset>

</form>
