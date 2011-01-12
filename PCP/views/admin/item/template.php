<?php 
	echo($item_form);
	if ($item->id > 0)
	{
?>
		<div id="accordion" >
		<h3 ><a href="#">Events</a></h3>
		<div style='display: none;' >
			<?php
				echo($event_list);
			?>
		</div>
	</div><!-- #accordion -->
<?php 
		echo($itemstate_list);
	}	
?>
