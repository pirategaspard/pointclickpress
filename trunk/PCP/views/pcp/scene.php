<table id="content_layout">
	<tr>
		<td>
			<?php 
				echo($scene_column_left);
			?>
		</td>
		<td>
			<?php 
				plugins::executeHook('display_pre_scene');
			?>

			<div id="scene">
				<!-- <h1 id="title"><?php //echo($scene->title); ?></h1> -->
				<?php echo($grid); ?>
				<p id="description"><?php echo($scene->description); ?></p>
			</div>

			<?php 
				plugins::executeHook('display_post_scene');
			?>
		</td>
		<td>
			<?php 
				echo($scene_column_right);
			?>
		</td>
	</tr>
</table>
	
