<?php
	$total = $story->grid_total();
	$items = $scene->items; 
	$cells = '';
	for($i=0;$i<$total;$i++)
	{
		$cells.= '<a n="'.$i.'" href="'.Kohana::$base_url.'cellClick?n='.$i.'" >';
		if (isset($items[$i]))
		{
			$cells.= '<img src="'.$story->getMediaPath().$items[$i]->image_id.'/'.$story->screen_size.'/'.$items[$i]->filename.'" />';	
		}
		$cells.= '</a>';
	}
?>	
	<div id="grid">
	<?php echo($cells); ?>		
	</div>
