<form action="/admin/auth/login" method="post" data-validate="true">

  <fieldset>
    <legend>Login</legend>

    <label>Email</label>
    <input type="text" name="email" value="admin@admin.com" placeholder="email">

    <label>Password</label>
		<input type="password" name="password" value="password" placeholder="password">

    <label class="checkbox">
      <input type="checkbox" name="remember" value="1" id="remember"> Remember Me
    </label>

    <p>
	    <button type="submit" class="btn">Submit</button>
	    <img src="" width="64" height="1">
	    <a href="/admin/auth/forgot">Forgot Password</a>
		</p>
		
		<p><a href="/admin/auth/register">Register</a></p>

  </fieldset>
</form>
