<div class="row header">
  <div class="span8">
		<h3>Menubars<small>The Menubar Page allows you to create the navigation menu for use in your layouts.</small></h3>
  </div>
  <div class="span4 txt-ar">
  	<a href="/admin/menubar/" class="btn btn-small">Cancel</i></a>
  	<a href="/admin/menubar/sort" class="btn btn-small" id="save_order_btn"><i class="icon-save"></i> Save Order</i></a>
  </div>
</div>
<?php
printTree($tree);
function printTree($tree) {
  if(!is_null($tree) && count($tree) > 0) {
    echo '<ol class="sortable">';
    foreach($tree as $node) {
      echo '<li id="node_'.$node->id.'" class="active_'.$node->active.'"><div class="element"><div class="text">'.$node->text.'</div><div class="sub">url: '.$node->url.' resource: '.$node->resource.'</div></div>';
      printTree($node->children);
      echo '</li>';
    }
    echo '</ol>';
  }
}
