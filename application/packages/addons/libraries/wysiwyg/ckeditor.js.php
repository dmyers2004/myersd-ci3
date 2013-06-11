	<script>
	window.onload = function() {
		
		CKEDITOR.stylesSet.add('my_custom_style', [
	    { name: 'My Custom Block', element: 'h3', styles: { color: 'blue'} },
	    { name: 'My Custom Inline', element: 'span', attributes: {'class': 'mine'} }
	  ]);

  	var options = <?=$options ?>;
  	
		CKEDITOR.replace('<?=$element_id ?>', options);
	};
</script>
