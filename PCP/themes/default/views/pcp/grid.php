<?php
	$total = $story->grid_total(); 
	$cells = '';
	for($n=1;$n<=$total;$n++)
	{
		// if there is an item for this cell
		if (isset($items[$n]) && count($items[$n]) > 0)
		{
			// add item to scene
			$cells.= '<div n="'.$n.'" >';
			$cells.= '<form n="'.$n.'" i="'.key($items[$n]).'" action="'.Kohana::$base_url.'itemclick?n='.$n.'" method="post" ><input type="image" src="'.$story->getMediaPath().current($items[$n])->getPath($story->screen_size).'" name="i" value="'.key($items[$n]).'" /></form>';
			$cells.= '</div>';
		}
		else
		{
			$cells.= '<a n="'.$n.'" href="'.Kohana::$base_url.'cellClick?n='.$n.'" ></a>';
		}
	}
?>	
	<div id="grid" >
	<?php echo($cells); ?>		
	</div>
