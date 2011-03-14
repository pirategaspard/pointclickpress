<?php 
	echo($itemstate_form);	
	if ($itemstate->id > 0)
	{
?>
	<div id="accordion" >
		<h3 ><a href="#">Events</a></h3>
		<div style='display: none;' >
			<?php
				echo($action_list);
			?>
		</div>
	</div><!-- #accordion -->
<?php } ?>
