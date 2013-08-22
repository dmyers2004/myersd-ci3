var tableOffset;
var header;
var fixedHeader;

function resize() {
 var totalwidth = $(".tab-content").css('width');
 
 fixedHeader.css('width', totalwidth);
 
 var widths = [];
 
 $('.table.table-hover:first thead th').each(function() {
   widths.push($(this).width());
 });
 
 var i=0;
 
 $('#header-fixed th').each(function() {
   this.width = widths[i];
   i++;
 });

}

function resizeAndShow() {
 var offset = $(this).scrollTop();

//console.log(offset);
 
 if (offset >= tableOffset && fixedHeader.is(":hidden")) {
   fixedHeader.show();
   resize();
 } else if (offset < tableOffset) {
   fixedHeader.hide();
 }
 
 fixedHeader.css('left', $(".tab-content").position().left - $(this).scrollLeft());
};

$(document).ready(function() {
  tableOffset = $(".tab-content").offset().top;

/**
 * need to re-clone on tab switch because the columns widths changes
 */

  header = $(".table.table-hover:first > thead").clone();
  fixedHeader = $("#header-fixed").append(header);

//console.log(tableOffset);

  $(window).bind("scroll", resizeAndShow);
  $(window).resize(resize);
});