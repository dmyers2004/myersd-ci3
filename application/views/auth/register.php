<form action="/auth/register" method="post" data-validate="true">

  <fieldset>
    <legend>Register</legend>

    <div class="control-group">
	    <label>User Name *</label>
	    <input type="text" name="username" value="Joe Coffee" placeholder="User Name">
		</div>

    <div class="control-group">
	    <label>Email *</label>
	    <input type="text" name="email" value="joe@example.com" placeholder="email">
		</div>

    <div class="password control-group">
	    <label>Password *</label>
			<input type="password" name="password" value="password" placeholder="password">
		</div>

    <div class="password control-group">
	    <label>Confirm Password *</label>
			<input type="password" class="error" name="repeat_password" value="password" placeholder="password again">
		</div>

    <p>
	    <button type="submit" class="btn">Submit</button>
	    <img src="" width="64" height="1">
	    <a href="/auth">Back to Login</a>
		</p>

		<label>* required</label>
		
  </fieldset>
</form>
