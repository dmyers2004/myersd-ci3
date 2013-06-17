$(document).ready(function(){

	$('.chosen').chosen();
	$('.selectcombobox').selectcombobox();
	$('.combobox').combobox();

	/* setup ajax href links */
	plugins.ajax_href.init();

	/* setup delete modal handler */
	plugins.delete_handler.init();
	
	/* setup the enum handler */
	plugins.enum_handler.init();
	
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

	$('.admin .table-hover td.click_edit').click(function(event) {
		window.location.replace($(this).parent().find("a:contains('Edit')").attr('href'));
	});

	$('.sortable').nestedSortable({
    handle: 'div',
    items: 'li',
    toleranceElement: '> div'
	});
	
	$('#save_order_btn').click(function(e) {
		e.preventDefault();
		var serialized = $('ol.sortable').nestedSortable('serialize');
		
		$.ajax({
		  type: "POST",
		  url: '/admin/menubar/sort',
		  data: serialized,
		  success: function(data, textStatus, jqXHR){
				if (data.err == false) {
					mvc.redirect('/admin/menubar/');
				} else {
					jQuery.noticeAdd({ text: 'Reorder Save Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });
				}
		  },
		  dataType: 'json'
		});
	});
	

});
