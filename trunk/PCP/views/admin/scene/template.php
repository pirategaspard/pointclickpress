<?php 	
	echo($scene_form);
	if ($scene->id > 0)
	{
		echo($event_add); 
		echo($event_list);
		echo($grid);
	
		if (strlen($scene->filename) > 0)
		{ 			
			echo('<div id="scene_data">');
			echo($item_form);
			echo($items_list);  
			echo($grid_event_form);
			echo($grid_event_list);
			echo('</div>');  	
		}
	}	
	
	//var_dump ($_SESSION);
?>
