<?=form_open('/auth/reset',array('data-validate'=>'true')) ?>
  <fieldset>
    <legend>Reset Password</legend>
    <input type="hidden" name="id" value="<?=$userid ?>">
    <input type="hidden" name="key" value="<?=$key ?>">

		<label class="control-label" for="password">
			<strong>Password</strong>
		</label>
		<input type="password" id="password" name="password" value="Password#1" placeholder="password">

		<label class="control-label" for="password">
			<strong>Confirm Password</strong>
		</label>
		<input type="password" id="confirm_password" name="confirm_password" value="Password#1" placeholder="password">

		<p><small><?=$password_format_txt ?></small><p>

    <p>
	    <button type="submit" class="btn">Submit</button>
			<span class="required-txt">Required Fields are in Bold</span>
		</p>
		
  </fieldset>
</form>
<a href="/auth">Back to Login</a>
