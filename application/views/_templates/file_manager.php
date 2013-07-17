<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?=$page_title ?></title>
<meta name="description" content="<?=$meta_description ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?=$page_meta ?>
<?=$page_css ?>
<style>
<?=$page_style ?>
</style>
</head>
<body>
<?=form_file_manager('file_manager',$options) ?>
<script>
var baseurl="<?=base_url() ?>";
var plugins={};
</script>
<?=$page_js ?>
<script>
<?=$page_script ?>
jQuery(document).ready(function() {<?=$page_onready ?>});
</script>
</body>
</html>