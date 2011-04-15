<table id="content_layout">
	<tr>
		<td>
			<?php 
				echo($scene_column_left);
			?>
		</td>
		<td>
			<?php 
				Events::announceEvent(DISPLAY_PRE_SCENE);
			?>

			<div id="scene" class='pointing'>
				<!-- <h1 id="title"><?php //echo($scene->title); ?></h1> -->
				<?php echo($grid); ?>
				<div id='loadingzone'><img src='images/loadingAnimation.gif' /></div>
				<p id="description"><?php echo($scene->description); ?></p>
			</div>

			<?php 
				Events::announceEvent(DISPLAY_POST_SCENE);
			?>
		</td>
		<td>
			<?php 
				echo($scene_column_right);
			?>
		</td>
	</tr>
</table>
	
