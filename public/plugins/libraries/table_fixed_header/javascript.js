var tableOffset;
var header;
var fixedHeader;

function resize() {
	var totalwidth = $(".tab-content").css('width');

	header = $(".active .table.table-hover > thead").clone();
	fixedHeader = $("#header-fixed").html(header);

	fixedHeader.css('width', totalwidth);

	var widths = [];

	$('.active .table.table-hover thead th').each(function() {
		widths.push($(this).width());
	});

	var i=0;

	$('#header-fixed th').each(function() {
		this.width = widths[i];
		i++;
	});

	fixedHeader.css('left', $(".tab-content").position().left - $(this).scrollLeft());
}

function resizeAndShow() {
	var offset = $(this).scrollTop();

	if (offset >= tableOffset && fixedHeader.is(":hidden")) {
		resize();
		fixedHeader.show();
	} else if (offset < tableOffset) {
		fixedHeader.hide();
	}
};

$(document).ready(function() {
	tableOffset = $(".tab-content").offset().top;

	resize();

	$(window).bind("scroll", resizeAndShow);
	$(window).resize(resize);
});