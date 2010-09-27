<fieldset>
	<legend>Interactive Story Information</legend>
	<form action="<?php echo($story_form_action); ?>" method="post" >
		<input type="hidden" name="id" value="<?php echo($story->id); ?>" >
		<label>
			Story Title
			<input type="text" name="title" value="<?php echo($story->title); ?>" >
		</label>
		<label>
			Story Author		
			<input type="text" name="author" value="<?php echo($story->author); ?>" >
		</label>
		<label>
			Story Description
			<textarea name="description"><?php echo($story->description); ?></textarea>
		</label>
		<label>
			Story Grid Size
			<select name="grid" >
				<option value="10x10" <?php if(strcmp($story->grid(),'10x10')===0) echo('selected="selected"'); ?>>10x10</option>
				<option value="25x25" <?php if(strcmp($story->grid(),'25x25')===0) echo('selected="selected"'); ?>>25x25</option>
				<option value="50x50" <?php if(strcmp($story->grid(),'50x50')===0) echo('selected="selected"'); ?>>50x50</option>
			</select>
		</label>        
		<label id="container_select" for="first_scene_container_id">First Scene Container:
		<select name="first_scene_container_id" >
			<option value="" >Select a Scene Container</option>
			<?php foreach($containers as $container)
			{
				$selected = '';
				if ($story->first_scene_container_id == $container->id) $selected = ' selected="selected" ';
				echo ('<option value="'.$container->id.'"'.$selected.' >'.$container->title.'</option>');
			} ?>
		</select>
		<label>
			Cover Image filename:
			<input type="hidden" name="image_id" value="<?php print($story->image_id); ?>" >
			<input type="text" name="image_filename" value="<?php print($story->filename); ?>" >
			<a href="<?php print($assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>
		</label>
		</label>
		<input type="submit" name="submit" value="Save" />
	</form>
</fieldset>
