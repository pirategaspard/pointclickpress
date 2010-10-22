<?php
	$total = $story->grid_total();
	$items = $scene->items; 
	var_dump($items);
	$cells = '';
	for($i=0;$i<$total;$i++)
	{
		$cells.= '<a n="'.$i.'" href="'.Kohana::$base_url.'cellClick?n='.$i.'" >';
		if (isset($items[$i]))
		{
			$cells.= '<img src="'.$items[$i].'" />';	
		}
		$cells.= '</a>';
	}
?>	
	<div id="grid">
	<?php echo($cells); ?>		
	</div>
