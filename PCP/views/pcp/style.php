<style>
	#scene_image {background-image:url(<?php echo($scene->getPath($story->scene_width,$story->scene_height))?>); width: <?php echo($story->scene_width)?>px;height:<?php echo($story->scene_height)?>px; overflow: hidden;}
	#scene_image a {display:block; width:<?php print($story->cell_width) ?>px; height: <?php print($story->cell_height) ?>px; float: left;}
</style>
