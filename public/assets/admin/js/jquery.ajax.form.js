var mvc = (mvc) || {};

jQuery.fn.ajaxForm = function(debug) {
	$(this).submit(function(e) {
		if (debug) {
			e.preventDefault();
		}

		/* create reference to form */
		var form = $(this);
		
		/* call and wait */
		var reply = mvc.request({data: form.mvcForm2Obj(), url: form.attr('action') + 'Validate', dataType: 'json'});

		if (reply === undefined) {
			mvc.ajaxFormRemove()
			return false;
		}

	
		/* if it's good then let the form submit */
		if (reply.err === false) {
			mvc.ajaxFormRemove()
			return true;
		}
		
		if ($('#form-error-shown').length > 0) {
			$('#form-error-shown').closest('.notice-item-wrapper').fadeOut('fast',function(){
				$(this).remove();
				reply = mvc.flash_msg_format(reply);
				mvc.ajaxFormAdd('',reply.flash_msg,1,'error');
			});
		} else {
			reply = mvc.flash_msg_format(reply);
			mvc.ajaxFormAdd('',reply.flash_msg,1,'error');
		}
		
		return false;
	});
};

mvc.flash_msg_format = function(reply) {
	reply.count = 0;
	for (var prop in reply.errors_array) {
		reply.count++;
	}
	reply.plural = (reply.count > 1) ? 's' : '';
	reply.flash_msg = '<strong id="form-error-shown">Validation Error' + reply.plural + '</strong><br/>' + reply.errors;

	return reply;
}

mvc.ajaxFormRemove = function() {
	$('#form-error-shown').closest('.notice-item-wrapper').remove();
}

mvc.ajaxFormAdd = function(title,errors,stay,type) {
	stay = (stay) ? stay : 1;
	type = (type) ? type : 'error';
	title = (title != '') ? '<strong id="form-error-shown">' + title + '</strong><br/>' : '';

	$.noticeAdd({ text: title + errors , stay: stay, type: type });	
}

mvc.ajax = {};

/* mvc ajax defaults */
mvc.ajax.options = {
	type: 'post', /* ajax default request method */
	dataType: '', /* request return type */
	async: false, /* leave this on */
	cache: false, /* should ajax requests be cached - should be false */
	timeout: 3000, /* we uses a few blocking ajax calls how long should we wait? */
	data: {} /* default data sent */
};

/*
Convert Form to JSON Object
basic
$("#form_id").mvcForm2Obj();
advanced - add additional payload
$("#form_id").mvcForm2Obj({'extra':'abc123'});
*/
jQuery.fn.mvcForm2Obj = function(obj) {
	obj = obj || {};

	/* convert form to json object */
	jQuery.each(jQuery(this).serializeArray(), function () {
		if (obj[this.name]) {
			if (!obj[this.name].push) {
				obj[this.name] = [obj[this.name]];
			}
			obj[this.name].push(this.value || '');
		} else {
			obj[this.name] = this.value || '';
		}
	});

	obj['mvc[postselector]'] = this.selector;

	return obj;
};

/*
client based redirect
*/
mvc.redirect = function (url) {
	window.location.replace(url);
};

/*
MVC Ajax
$.mvcAjax({});
*/
mvc.request = function(settings) {
	settings = settings || {};

	/* clear errors an responds */
	mvc.ajax.responds = undefined;
	mvc.ajax.jqxhr = undefined;
	mvc.ajax.textstatus = undefined;
	mvc.ajax.errorthrown = undefined;

	/* setup a few defaults in here not in the config this can be overridden via settings */
	mvc.ajax.options.success = function(responds) {
		mvc.ajax.responds = responds;
	};

	mvc.ajax.options.error = function(jqXHR, textStatus, errorThrown) {
		mvc.ajax.jqxhr = jqXHR;
		mvc.ajax.textstatus = textStatus;
		mvc.ajax.errorthrown = errorThrown;
	};

	/* merge it all together */
	complete = jQuery.extend({},mvc.ajax.options,settings);

	/* make request */
	jQuery.ajax(complete);

	/* return responds */
	return mvc.ajax.responds;
};
