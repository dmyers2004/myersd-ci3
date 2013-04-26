plugins.flash_msg = {};
plugins.flash_msg.pause = 3000;

/* Deprecated for enum handler */
plugins.ajax_href = {};

plugins.ajax_href.init = function() {
	jQuery('.ajax-href').click(function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		jQuery.ajax({url: href, dataType: 'json'}).done(function(data, textStatus, jqXHR) {
			if (data.notice !== undefined) {
				var text = (data.notice.text) ? data.notice.text : 'It\'s Good!';
				var stay = (data.notice.stay) ? data.notice.stay : false;
				var type = (data.notice.type) ? data.notice.type : 'info';

				jQuery.noticeAdd({ text: text, stay: stay, type: type, stayTime: plugins.flash_msg.pause });	
			}
			if (data.href !== undefined) {
				if (data.href !== '') {
					window.location.replace(data.href);
				}
			}
		}).error(function(data){
			jQuery.noticeAdd({ text: 'Link Error', stay: '', type: 'notice', stayTime: plugins.flash_msg.pause });	
		});
	});
};

/* Deprecated for enum handler */
plugins.activate_handler = {};

plugins.activate_handler.init = function() {

	jQuery('.activate_handler').click(function(e){
		e.preventDefault();
		
		var that = this;
		var href = $(this).attr('href');

		jQuery.ajax({url: href, dataType: 'json'}).done(function(data, textStatus, jqXHR) {
			if (data.err === false) {
				var newhref = mvc.dirname(href) + '/' + ((mvc.basename(href) == 0) ? 1 : 0);
				$(that).attr('href',newhref).closest('tr').find('.activate_handler i').toggleClass('icon-circle-blank icon-ok-circle');

				var dda = $(that).closest('tr').find('.dropdown-menu a[href="' + newhref + '"]');
				copy = (dda.html() == 'Activate') ? 'Deactivate' : 'Activate';
				dda.html(copy);

				jQuery.noticeAdd({ text: 'Active Status Changed', stay: '', type: 'success', stayTime: plugins.flash_msg.pause });
			} else {
				jQuery.noticeAdd({ text: 'Active Status Change Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });			
			}
		}).error(function(data){
			jQuery.noticeAdd({ text: 'Active Status Change Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });			
		});

	});

};

plugins.delete_handler = {};

plugins.delete_handler.init = function() {

	jQuery('body').append('<div id="delete_modal" class="modal hide fade" tabindex="-1"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button><h3 id="myModalLabel">Delete Record</h3></div><div class="modal-body"><p>Are you sure you would like to delete this record?</p></div><div class="modal-footer"><button class="btn" data-dismiss="modal">No</button><button id="delete_modal_yes_btn" class="btn btn-danger">Yes, Delete it</button></div></div>');

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
		var href = $(that).attr('href');
		
		jQuery.ajax({url: href, dataType: 'json'}).done(function(data, textStatus, jqXHR) {
			if (data.err === false) {
				
				var ary = $(that).data('enum').split('|');
				var option = parseInt(mvc.basename(href));
				var num = option + 1;
				if (num > (ary.length - 1)) {
					num = 0;	
				}

				$(that).attr('href',mvc.dirname(href) + '/' + num).find('i').prop('class','').prop('class',ary[option]);
				
				jQuery.noticeAdd({ text: 'Active Status Changed', stay: '', type: 'success', stayTime: plugins.flash_msg.pause });
			} else {
				jQuery.noticeAdd({ text: 'Active Status Change Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });			
			}
		}).error(function(data){
			jQuery.noticeAdd({ text: 'Active Status Change Error', stay: '', type: 'error', stayTime: plugins.flash_msg.pause });			
		});

	});
};

