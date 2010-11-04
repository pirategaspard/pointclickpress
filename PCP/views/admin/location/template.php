<?php 
	echo($location_form);
	if ($location->id > 0)
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
	</div><!-- #accordion -->
<?php
		echo($scene_list); 	
	}
?>
