<?php 
	$cells = '';
	$total = $story->grid_total();
	for($i=0;$i<=$total;$i++)
	{
		$cells.= '<a n="'.$i.'" href="'.Kohana::$base_url.'index.php/cellClick?n='.$i.'" ></a>';
	}
?>	
	<div id="scene_image">
	<?php echo($cells); ?>		
	</div>
