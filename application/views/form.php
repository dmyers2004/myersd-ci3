<form action="/form/save" method="post">
  <textarea name="content" id="content" class="textarea"><?=$content_html ?></textarea>
  <?=display_ckeditor($ckeditor) ?>
  <input type="submit" value="Save" />
</form>
