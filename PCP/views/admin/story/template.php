<?php 
	echo($story_form);
	if ($story->id > 0)
	{
?>
	<div id='accordion' >
		<h3><a href='#'>Actions</a></h3>
		<div style='display: none;' >
			<?php 
				echo($action_list);
			?>	
		</div>
		<h3><a href='#'>Items</a></h3>
		<div style='display: none;' >
			<?php
				echo($item_list);
			?>
		</div>
		<h3><a href='#'>Plugins</a></h3>
		<div style='display: none;' >
			<?php
				echo($plugin_list);
			?>
		</div>
	</div><!-- #accordion -->
<?php					
		echo($location_list);
	}	
?>
