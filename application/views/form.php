<form action="/form/save" method="post">
  <textarea name="content" id="content" class="textarea"><?php echo $content_html ?></textarea>
  <?php echo display_ckeditor($ckeditor) ?>
  <input type="submit" value="Save" />
</form>