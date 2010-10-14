<?php
	$cells = Cache::instance()->get('cells'.$story->grid_total(),NULL);
	if (!$cells)
	{
		$total = $story->grid_total();
		for($i=0;$i<$total;$i++)
		{
			$cells.= '<a n="'.$i.'" href="'.Kohana::$base_url.'cellClick?n='.$i.'" ></a>';
		}
		Cache::instance()->set('cells'.$story->grid_total(),$cells);
	}
?>	
	<div id="grid">
	<?php echo($cells); ?>		
	</div>
