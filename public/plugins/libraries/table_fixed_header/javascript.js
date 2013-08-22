$(document).ready(function() {

	$('.table.table-hover .header').affix({ offset: $(".header").position().top });
	
	/* clone widths */
	var header_width = $('.tab-content').width();
	
	console.log(header_width);
	
	$('.table.table-hover .header:first').css({width: header_width});

	var widths = [];
	$('thead th').each(function() {
		widths.push($(this).width());
	});
	
		console.log(widths);		

});
