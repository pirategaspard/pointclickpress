<?php if (isset($story)) { ?>
<fieldset>
	<legend>Interactive Story Information</legend>
	<form action="<?php echo($story_form_action); ?>" method="post" >
		<input type="hidden" name="id" value="<?php echo($story->id); ?>" >
		<label>
			Story Title
			<input type="text" name="title" size="50" value="<?php echo($story->title); ?>" >
		</label>
		<label>
			Story Author		
			<input type="text" name="author" value="<?php echo($story->author); ?>" >
		</label>
		<label>
			Story Description
			<textarea name="description" cols="50"><?php echo($story->description); ?></textarea>
		</label>
		<label>
			Story Grid Size
			<select name="grid" >
				<option value="10x10" <?php if(strcmp($story->grid(),'10x10')===0) echo('selected="selected"'); ?>>10x10</option>
				<option value="25x25" <?php if(strcmp($story->grid(),'25x25')===0) echo('selected="selected"'); ?>>25x25</option>
				<option value="50x50" <?php if(strcmp($story->grid(),'50x50')===0) echo('selected="selected"'); ?>>50x50</option>
			</select>
		</label> 
		<?php if (count($locations) > 0) { ?>       
		<label id="location_select" for="first_location_id">First Scene location:
			<select name="first_location_id" >
				<option value="" >Select a Scene location</option>
				<?php foreach($locations as $location)
				{
					$selected = '';
					if ($story->first_location_id == $location->id) $selected = ' selected="selected" ';
					echo ('<option value="'.$location->id.'"'.$selected.' >'.$location->title.'</option>');
				} ?>
			</select>
		</label>
		<?php } ?>
		<?php if ($story->id > 0) { ?>
		<label>
			Cover Image filename:
			<input type="hidden" name="image_id" value="<?php print($story->image_id); ?>" >
			<input type="text" name="image_filename" value="<?php print($story->filename); ?>" >
			<a href="<?php print($assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>
		</label>
		<?php } ?>	
		<?php if ($story->id > 0) { ?>
		<label>
			Status:
			<select name="status" >
				<option value="p" <?php if(strcmp($story->status,'p')===0) echo('selected="selected"'); ?>>Published</option>
				<option value="d" <?php if(strcmp($story->status,'d')===0) echo('selected="selected"'); ?>>Draft</option>
			</select>
		</label>
		<?php } ?>	
		<input type="submit" name="submit" value="Save" />
	</form>
</fieldset>
<?php } ?>