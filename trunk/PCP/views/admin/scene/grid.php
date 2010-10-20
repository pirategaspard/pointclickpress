<?php 
	if (($scene->id > 0)&&(strlen($scene->filename)))
	{
		$cells = '';
		$total = $story->grid_total();
		$items = $scene->items; 
		for($i=0;$i<$total;$i++)
		{
			$cells.= '<b n="'.$i.'">';
			if (isset($items[$i]))
			{
				$cells.= '<img src="'.Kohana::$base_url.MEDIA_PATH.'/'.trim($scene->story_id).'/'.$items[$i]->image_id.'/100x100/'.$items[$i]->filename.'" />';	
			}
			$cells.= '</b>';
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
