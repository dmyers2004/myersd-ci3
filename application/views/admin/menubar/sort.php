<div class="row header">
  <div class="span8">
		<h3>Menubars<small>The Menubar Page allows you to create the navigation menu for use in your layouts.</small></h3>
  </div>
  <div class="span4 txt-ar">
  	<a href="/admin/menubar/" class="btn btn-small">Cancel</i></a>
  </div>
</div>
<div class="dd">
<?php
printTree($tree);

function printTree($tree) {
  if(!is_null($tree) && count($tree) > 0) {
    echo '<ol class="dd-list">';
    foreach($tree as $node) {
      echo '<li id="node_'.$node->id.'" class="dd-item dd3-item active_'.$node->active.'" data-id="'.$node->id.'">';
      echo '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">'.$node->text.'</div>';
      printTree($node->children);
      echo '</li>';
    }
    echo '</ol>';
  }
}
?>
</div>
