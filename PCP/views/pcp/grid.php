<?php
	$total = $story->grid_total();
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
	<div id="grid" class='pointing'>
	<?php echo($cells); ?>		
	</div>
