<?php 
	$cells = '';
	$total = $story->grid_total();
	for($i=0;$i<=$total;$i++)
	{
		$cells.= '<a n="'.$i.'" href="'.Kohana::$base_url.'cellClick?n='.$i.'" ></a>';
	}
?>	
	<div id="grid">
	<?php echo($cells); ?>		
	</div>
