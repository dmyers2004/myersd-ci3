plugins.nestable = {};

plugins.nestable.init = function() {
	
	var config = {};
	
	$('.dd').nestable(config);
	
	/* save on change */
	$('.dd').on('change', function() {
		var serialized = $('.dd').nestable('serialize');

		$.ajax({
		  type: "POST",
		  url: '/admin/menubar/sort',
		  data: {order: serialized},
		  success: function(data, textStatus, jqXHR){
				if (data.err == false) {
					$('.itsgood').fadeIn().delay(500).fadeOut();
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
					$('#menuRecord').html(data);
				} else {
					jQuery.noticeAdd({ text: 'Record Load Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });
				}
		  },
		  dataType: 'html'
		});
		
	});

}; /* end */