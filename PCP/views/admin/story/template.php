<?php 
	echo($story_form);
	if ($story->id > 0)
	{
?>
	<div id="accordion">
		<h3><a href="#">Events</a></h3>
		<div>
			<?php 
			echo($event_add);
			echo($event_list);
			?>	
		</div>
		<h3><a href="#">Items</a></h3>
		<div>
			<?php
			echo($item_add);
			echo($item_list);
			?>
		</div>
	</div><!-- #accordion -->
<?php					
		echo($location_list);
	}	
?>
