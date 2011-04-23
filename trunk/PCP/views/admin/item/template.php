<?php 
	echo($item_form);
	if ($griditem->id > 0)
	{
?>
		<div id="accordion" >
		<h3 ><a href="#">Actions</a></h3>
		<div style='display: none;' >
			<?php
				echo($action_list);
			?>
		</div>
	</div><!-- #accordion -->
<?php 
	}	
?>
