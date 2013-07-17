$(document).ready(function(){

	/* patch bootstrap button */
	$('.no-link-look').each(function(i){
		$(this).parent().attr('onclick','location.href=\'' + $(this).attr('href') + '\'');
	});

	$('input.shift-group').click(function(event) {
    if (event.shiftKey) {
		  $('[data-group="' + $(this).data('group') + '"]').prop('checked',($(this).prop('checked') || false));
    }
	});

	$('.admin .table-hover td.click_edit').click(function(event) {
		window.location.replace($(this).parent().find("a:contains('Edit')").attr('href'));
	});

	if (plugins.nestable) {
		plugins.nestable.init();
	}

	$('body').tooltip({
		selector: "i[data-toggle=tooltip]"
  })
});