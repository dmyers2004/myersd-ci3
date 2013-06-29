

<?=$container ?>




function elfinderGetUrlParam(paramName){var reParam=new RegExp('(?:[\?&]|&amp;)'+paramName+'=([^&]+)','i');var match=window.location.search.match(reParam);return(match&&match.length>1)?match[1]:''}
function adjustHeight(elfinder){var win_height=$(window).height();if(elfinder.height()!=win_height){elfinder.height(win_height-<?=$bottom_footer_offset?>).resize()}}
