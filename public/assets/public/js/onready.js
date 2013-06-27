jQuery(document).ready(function(){

	$('.working-img').spin({ lines: 8, length: 3, width: 4, radius: 6, speed: 1, trail: 50, hwaccel: true }).fadeOut('fast');

	/* my ajax form handler */
	$('form[data-validate=true]').ajaxForm();
	
	$('input[name=password], input[name=repeat_password]').keyup(function(e){
		if ($('input[name=password]').val().length < 8) {
			$('.password.control-group:first').addClass('error');
		} else {
			$('.password.control-group:first').removeClass('error');
		}

		if ($(this).val() !== $('input[name=password]').val()) {
			$('.password.control-group').addClass('error');
		} else {
			$('.password.control-group').removeClass('error');
		}
	});
	
});
