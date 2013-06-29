<!DOCTYPE html>
<head>
	<title><?=$meta_title ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?=$page_meta ?>
	<body class="fileManagerHandler">
		<?=form_file_manager('file_manager',$options) ?>
	</body>
	<?=$page_footer ?>
</html>
