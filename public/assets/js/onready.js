$(document).ready(function(){

	/* my ajax form handler */
	$('form[data-validate=true]').ajaxForm();
	
	$('.chosen').chosen();
	$('.selectcombobox').selectcombobox();
	$('.combobox').combobox();

	/* setup ajax href links */
	plugins.ajax_href.init();

	/* setup delete modal handler */
	plugins.delete_handler.init();
	
	/* setup the activate handler */
	plugins.activate_handler.init();
	
	/* patch bootstrap button */
	$('.no-link-look').each(function(i){
		$(this).parent().attr('onclick','location.href=\'' + $(this).attr('href') + '\'');
	});

	$('.table-fixed-header').fixedHeader()
	
	
	$('input.shift-group').click(function(event) {
    if (event.shiftKey) {
		  $('[data-group="' + $(this).data('group') + '"]').prop('checked',($(this).prop('checked') || false));
    } 
	});
	
	
});