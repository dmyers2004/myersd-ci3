jQuery(document).ready(function(){
	
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
