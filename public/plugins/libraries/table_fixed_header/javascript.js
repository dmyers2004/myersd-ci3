var magicheader = {};

magicheader.tableOffset;
magicheader.header;
magicheader.fixedHeader;
magicheader.container;

magicheader.config = {
	container: '.table-fixed-header'
};

/* this is tied to the tabs - other tabs not working? */

magicheader.init = function(options) {
	
	if (options){
		$.extend(magicheader.config, options);
	}
	
	magicheader.container = $(magicheader.config.container);
	
	if (magicheader.container.length == 0) {
		return;	
	}
	
	magicheader.container.append('<table id="magic-header-fixed" class="table table-hover"></table>');

	magicheader.tableOffset = magicheader.container.offset().top;

	magicheader.resize();

	$(window).bind('scroll', magicheader.resizeAndShow).resize(magicheader.resize);
}

magicheader.resize = function() {
	var totalwidth = magicheader.container.css('width');

	magicheader.header = $('.active .table-fixed-header > thead').clone();
	magicheader.fixedHeader = $('#magic-header-fixed').html(magicheader.header);

	magicheader.fixedHeader.css('width', totalwidth);

	var widths = [];

	$('.active .table-fixed-header thead th').each(function() {
		widths.push($(this).width());
	});

	var i=0;

	$('#magic-header-fixed th').each(function() {
		this.width = widths[i];
		i++;
	});

	magicheader.fixedHeader.css('left', magicheader.container.position().left - $(this).scrollLeft());
}

magicheader.resizeAndShow = function() {
	var offset = $(this).scrollTop();

	if (offset >= magicheader.tableOffset && magicheader.fixedHeader.is(':hidden')) {
	
		magicheader.resize();
		magicheader.fixedHeader.show();
	
	} else if (offset < magicheader.tableOffset) {
	
		magicheader.fixedHeader.hide();
	
	}
};
