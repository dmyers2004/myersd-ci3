<script>
function elfinderGetUrlParam(paramName) {
	var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
	var match = window.location.search.match(reParam) ;
	return (match && match.length > 1) ? match[1] : '' ;
}

function adjustHeight(elfinder) {
	var win_height = $(window).height();
	if( elfinder.height() != win_height ){
		elfinder.height(win_height - <?=$bottom_footer_offset ?>).resize();
	}
}

jQuery(document).ready(function(){

	var options = <? echo $options ?>;

	options.getFileCallback = function(file) {
		//console.log(file);
	  window.opener.CKEDITOR.tools.callFunction(elfinderGetUrlParam('CKEditorFuncNum'), file.url);
	  window.close();
	}

	var elf = jQuery('#<?=$element_id ?>').elfinder(options);
	
	if (<?=$auto_resize ?> == 1) {
		adjustHeight(elf);
	}

});
</script>
