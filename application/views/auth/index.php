<?=form_open('/auth/login',array('data-validate'=>'true')) ?>
  <fieldset>
    <legend>Login</legend>

		<label class="control-label" for="email">
			<strong>Email</strong>
		</label>
		<input type="text" id="email" name="email" value="donmyers@me.com" placeholder="email">

		<label class="control-label" for="password">
			<strong>Password</strong>
		</label>
		<input type="password" id="password" name="password" value="password" placeholder="password">

		<label class="checkbox" for="remember">
		  <input type="checkbox" id="remember" name="remember" value="1" <?=($rememberme) ? 'checked' : '' ?>> Remember Me
		</label>

    <p>
	    <button type="submit" class="btn">Submit</button>
			<span class="required-txt">Required Fields are in Bold</span>
		</p>
		
  </fieldset>
</form>
<a href="/auth/register">Register</a>
<img width=32 height=0>
<a href="/auth/forgot">Forgot Password</a>
