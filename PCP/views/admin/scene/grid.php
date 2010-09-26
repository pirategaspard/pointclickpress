<?php 
	if (($scene->id > 0)&&(strlen($scene->filename)))
	{
		$cells = '';
		$total = $story->grid_total();
		for($i=0;$i<$total;$i++)
		{
			$cells.= '<b n="'.$i.'"></b>';
		}
?>	
	<style>
		#grid {background-image:url(<?php echo($scene->getPath())?>); width: <?php print($story->scene_width) ?>px;height: <?php print($story->scene_height) ?>px; overflow: hidden;}
		#grid b {display:block; width:<?php print($story->cell_width) ?>px; height: <?php print($story->cell_height) ?>px; float: left; border: solid 1px black; margin: -1px;} /* border: solid 1px black; */
		#grid b.not_selected {border: 1px solid black; }
		#grid b.selected {border: 1px solid red; }
	</style>
	<div id="grid">
	<?php echo($cells); ?>		
	</div>
<?php } ?>	
