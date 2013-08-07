/**
 * Convert Input or select into a ComboBox
 */

jQuery.fn.combobox = function(options) {
	return this.each(function(){
		if (jQuery(this).is('select')) {
			jQuery(this).selectcombobox(options);
		} else {
			jQuery(this).inputcombobox(options);
		}
	});
}

jQuery.fn.inputcombobox = function(options){
	return this.each(function(){
		options = (options) ? options : {};

		jQuery(this).typeahead({
			source: options.source,
			/* patch on our custom matcher */
	  	matcher: function(item) {
	  		if (this.query == '*') {
	  			return true;
	  		} else {
	  			return item.indexOf(this.query) >= 0;
	  		}
	  	}
		});

  	var that = this;

  	/* append on the drop arrow */
  	jQuery(this).wrap('<div class="input-append">')
			.after('<div class="btn-group"><a class="btn dropdown-toggle"><span class="caret"></span></a></div>')
			.next()
			.click(function(e) {
				/* pause longer than bootstrap so the dropdown doesn't cause the input field to lose focus 150 */
				setTimeout(function () {
					var current = jQuery(that).val();
					jQuery(that).val('*').typeahead('lookup').val(current).focus();
				}, 300);
		});
  });
};

jQuery.fn.selectcombobox = function(options){
	return this.each(function(){
		options = (options) ? options : {};

		var select = jQuery(this);

  	options.source = [];
		jQuery('option',this).each(function(i){
			options.source[i] = jQuery(this).text();
		});

		var custom_identifier = 'combopop' + Math.random().toString(36).substring(7);

  	select.after('<input type="text" autocomplete="off" class="' + custom_identifier + ' ' +(select.attr('class') || '')+'" value="' + jQuery('option:selected',this).text() + '" placeholder="'+(select.attr('placeholder') || '')+'" id="'+(select.attr('id') || '')+'" name="'+select.attr('name')+'">').remove();

		/* call combobox */
		jQuery('.' + custom_identifier).inputcombobox(options);
  });
};