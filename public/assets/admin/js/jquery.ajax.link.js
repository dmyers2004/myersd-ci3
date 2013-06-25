var plugins = (plugins) || {};

plugins.flash_msg = {};
plugins.flash_msg.pause = 3000;

plugins.delete_handler = {};

plugins.delete_handler.init = function() {

	jQuery('body').append('<div id="delete_modal" class="modal hide fade" tabindex="-1"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button><h3 id="myModalLabel">Delete Record</h3></div><div class="modal-body"><p>Are you sure you would like to delete this record?</p></div><div class="modal-footer"><button class="btn" data-dismiss="modal">No</button><button id="delete_modal_yes_btn" class="btn btn-danger">Yes, Delete it</button></div></div>');

	jQuery(document).on('click','.delete-button',function(e){
		e.preventDefault();
		var id = $(this).data('id');
		jQuery('#delete_modal').data('row',jQuery('#node_'+id)).data('href',jQuery(this).attr('href')).modal('show');
	});

	jQuery('.delete_handler').click(function(e){
		e.preventDefault();
		jQuery('#delete_modal').data('row',jQuery(this).closest('tr')).data('href',jQuery(this).attr('href')).modal('show');
	});

	jQuery('#delete_modal_yes_btn').click(function(e){
		jQuery('#delete_modal').modal('hide');
		var row = $('#delete_modal').data('row');
		var href = $('#delete_modal').data('href');
		
		jQuery.ajax({url: href, dataType: 'json'}).done(function(data, textStatus, jqXHR) {
			if (data.err == false) {
				$(row).fadeOut();
				jQuery.noticeAdd({ text: 'Record Deleted', stay: '', type: 'info', stayTime: plugins.flash_msg.pause });
			} else {
				jQuery.noticeAdd({ text: 'Record Deletion Error', stay: '', type: 'notice', stayTime: plugins.flash_msg.pause });
			}
		}).error(function(data){
				jQuery.noticeAdd({ text: 'Record Deletion Error', stay: '', type: 'notice', stayTime: plugins.flash_msg.pause });
		});

	});

};

/* this should handle any enum status click event */
plugins.enum_handler = {};

plugins.enum_handler.init = function() {

	jQuery('.enum_handler').click(function(e){
		e.preventDefault();
		
		var that = this;
		var href = $(this).attr('href');
		var value = ($(this).data('value')) + 1;
		var values = $(this).data('enum').split('|');
		var max = (values.length)-1;
		
		value = (value > max) ? 0 : value;
		
		jQuery.ajax({url: href + value , dataType: 'json'}).done(function(data, textStatus, jqXHR) {
			if (data.err === false) {
				$(that).data('value',value).find('i').prop('class','').prop('class',values[value]);
				
				jQuery.noticeAdd({ text: 'Recorded Updated', stay: '', type: 'success', stayTime: plugins.flash_msg.pause });
			} else {
				jQuery.noticeAdd({ text: 'Recorded Update Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });			
			}
		}).error(function(data){
			jQuery.noticeAdd({ text: 'Recorded Update Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });			
		});

	});
};

