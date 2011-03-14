<?php 
	echo($itemdef_form);
	if ($itemdef->id > 0)
	{
?>
		<div id="accordion" >
		<h3 ><a href="#">Events</a></h3>
		<div style='display: none;' >
			<?php
				echo($action_list);
			?>
		</div>
		<h3 ><a href="#">Item Instances</a></h3>
		<div style='display: none;' >
			<?php
				echo($iteminstances_list);
			?>
		</div>
	</div><!-- #accordion -->
<?php 
		echo($itemstate_list);
	}	
?>

