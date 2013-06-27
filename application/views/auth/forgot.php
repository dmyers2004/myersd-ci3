<?=form_open('/auth/forgot',array('data-validate'=>'true')) ?>
  <fieldset>
    <legend>Forgot Password</legend>

		<label class="control-label" for="email">
			<strong>Email</strong>
		</label>
		<input type="text" id="email" name="email" value="" placeholder="email">

    <p>
	    <button type="submit" class="btn">Submit</button>
			<span class="required-txt">Required Fields are in Bold</span>
		</p>
		
  </fieldset>
</form>
<a href="/auth">Back to Login</a>
