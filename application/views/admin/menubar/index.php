<div class="row header">
  <div class="span8">
		<h3>Menubars<small>The Menubar Page allows you to create the navigation menu for use in your layouts.</small></h3>
  </div>
  <div class="span4 txt-ar">
  	<a href="/admin/menubar/new" class="btn btn-small"><i class="icon-magic"></i> Add Root Menubar</i></a>
  </div>
</div>
<div class="row-fluid">
  <div class="span6 dd">
		<?=make($tree) ?>
	</div>
	<div id="menuRecord" class="span6">
		<fieldset class="subview">
		</fieldset>
	</div>
</div>

<?php 

function make($tree, $parent_id = 0) {
  $child = hasChildren($tree, $parent_id);
  
  if (empty($child)) return '';
  
  $content = '<ol class="dd-list">';

  foreach ( $child as $node ) {

  	$content .= '<li id="node_'.$node->id.'" class="dd-item dd3-item" data-id="'.$node->id.'">';
    $content .= '<div class="dd-handle dd3-handle">Drag</div><div class="dd3-content active_'.$node->active.'">'.$node->text.' <small>'.$node->url.'</small></div>';
    $content .= make($tree, $node->id);
		$content .= '</li>';
  	
  }

  $content .= '</ol>';

  return $content;
}

function hasChildren($tree, $parent_id) {
  return array_filter($tree, function ($var) use($parent_id) {
    return $var->parent_id == $parent_id;
  });
}
