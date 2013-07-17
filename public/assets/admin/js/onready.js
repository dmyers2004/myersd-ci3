$(document).ready(function(){

	/* patch bootstrap button */
	$('.no-link-look').each(function(i){
		$(this).parent().attr('onclick','location.href=\'' + $(this).attr('href') + '\'');
	});

	/* handle shift when selecting group access */
	$('input.shift-group').click(function(event) {
    if (event.shiftKey) {
		  $('[data-group="' + $(this).data('group') + '"]').prop('checked',($(this).prop('checked') || false));
    }
	});
	
	/* Handle click on .click_edit cell in tables */
	$('.admin .table-hover td.click_edit').click(function(event) {
		window.location.replace($(this).parent().find("a:contains('Edit')").attr('href'));
	});

	/* handle tooltips */
	$('body').tooltip({
		selector: "i[data-toggle=tooltip]"
  });
  
});