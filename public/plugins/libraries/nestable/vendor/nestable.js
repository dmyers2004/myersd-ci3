plugins.nestable = {};

plugins.nestable.init = function() {
	
	var config = {};
	
	$('.dd').nestable(config);
	
	$('.dd').nestable('collapseAll');
		
	/* save on change */
	$('.dd').on('change', function() {
		var serialized = $('.dd').nestable('serialize');
		$('.working-img').fadeIn('fast');
		
		$.ajax({
		  type: "POST",
		  url: '/admin/menubar/sort',
		  data: {order: serialized},
		  success: function(data, textStatus, jqXHR){
				if (data.err == false) {
					$('.working-img').fadeOut('slow');
				} else {
					jQuery.noticeAdd({ text: 'Reorder Save Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });
				}
		  },
		  dataType: 'json'
		});

	});
	
	/* show record on click */
	$('.dd3-content').on('click',function(e) {
		var id = $(this).closest('li').data('id');
		
		$.ajax({
		  type: 'GET',
		  url: '/admin/menubar/record/' + id,
		  success: function(data, textStatus, jqXHR){
				if (false == false) {
					$('#menuRecord .subview').html(data);
				} else {
					jQuery.noticeAdd({ text: 'Record Load Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });
				}
		  },
		  dataType: 'html'
		});
		
	});

}; /* end */