<div class="row">
  <div class="span9">
		<h3>Reorganize <?=$page_titles ?><small>Drag and Drop menus to the correct order. Remember Bootstrap show no more then show 2 levels.</small></h3>
  </div>
  <div style="padding-top: 3px;" class="span3 txt-ar">
  	<a href="/admin/<?=$controller ?>/" class="btn btn-small">Cancel</i></a>
  	<a href="/admin/<?=$controller ?>/save" id="save_order_btn" class="btn btn-small"><i class="icon-save"></i> Save Order</i></a>
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
