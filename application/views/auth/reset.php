<?=form_open('/auth/register',array('data-validate'=>'true')) ?>
  <fieldset>
    <legend>Reset Password</legend>

		<label class="control-label" for="password">
			<strong>Password</strong>
		</label>
		<input type="password" id="password" name="password" value="" placeholder="password">

		<label class="control-label" for="password">
			<strong>Confirm Password</strong>
		</label>
		<input type="password" id="confirm_password" name="confirm_password" value="" placeholder="password">

    <p>
	    <button type="submit" class="btn">Submit</button>
			<span class="required-txt">Required Fields are in Bold</span>
		</p>
		
  </fieldset>
</form>
<a href="/auth">Back to Login</a>
