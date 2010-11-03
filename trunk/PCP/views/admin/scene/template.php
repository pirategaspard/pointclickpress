<?php 	
	echo($scene_form);
	if ($scene->id > 0)
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
		echo($grid);
	
		if (strlen($scene->filename) > 0)
		{ 			
			//echo('<div id="scene_data">');
		?>						
			
			<div id="tabs">
				<ul>
			        <li><a href="#tab-1"><span>Grid Events</span></a></li>
			        <li><a href="#tab-2"><span>Grid Items</span></a></li>
			    </ul>
			    <div id="tab-1">
			    	<?php 
					echo($grid_event_form);
					echo($grid_event_list);
					?>
				</div>
				<div id="tab-2">
			    	<?php 
			    	echo($item_form);
					echo($items_list);
			    	?>
			    </div>		
			</div><!-- #tabs -->
<?php   	
		}
	}	
	//var_dump ($_SESSION);
?>
