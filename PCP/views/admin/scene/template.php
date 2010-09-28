<?php 

	echo($story_info);
	echo($location_info);
	echo($scene_info);
	echo($scene_add);
	echo($scene_form);
	if ($scene->id > 0)
	{
		echo($event_add); 
		echo($event_list);
		echo($grid);
	
		if (strlen($scene->filename) > 0)
		{ 
			//echo($grid_event_add); 
			echo($grid_event_form);
			echo($grid_event_list);  	
		}
	}	
	
	//var_dump ($_SESSION);
?>
