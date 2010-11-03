<?php if (isset($story)) { ?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Interactive Story Information</legend>
	<form action="<?php echo($story_form_action); ?>" method="post" >
		<input type="hidden" name="id" value="<?php echo($story->id); ?>" >
		<div class="form_block" >
			<p>			
				<label>Story Title:</label>
				<input type="text" name="title" size="50" value="<?php echo($story->title); ?>" >
			</p>
			<p>			
				<label>Story Author:</label>		
				<input type="text" name="author" value="<?php echo($story->author); ?>" >
			</p>
			<p>				
				<label>Story Description:</label>
				<textarea name="description" cols="50"><?php echo($story->description); ?></textarea>
			</p>
		</div>
		<div class="form_block" >
			<label>Story Grid Size</label> 
			<select name="grid" >
				<?php foreach($grid_sizes as $size)
					{ ?>					
					<option value="<?php echo $size; ?>" <?php if(strcmp($story->grid(),$size)===0) echo('selected="selected"'); ?>><?php echo $size; ?></option>
				<?php } ?>
			</select>			
			<?php if (count($locations) > 0) { ?>       
			<label id="location_select" for="first_location_id">First Location:</label>
			<select name="first_location_id" >
				<option value="" >Select a Scene location</option>
				<?php foreach($locations as $location)
				{
					$selected = '';
					if ($story->first_location_id == $location->id) $selected = ' selected="selected" ';
					echo ('<option value="'.$location->id.'"'.$selected.' >'.$location->title.'</option>');
				} ?>
			</select>			
			<?php } ?>
		</div>
		<div class="form_block" >
			<?php if ($story->id > 0) { ?>
			<label>Cover Image filename:</label>
				<input type="hidden" name="image_id" value="<?php print($story->image_id); ?>" >
				<input type="text" name="image_filename" value="<?php print($story->filename); ?>" >
				<a href="<?php print($assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>			
			<?php } ?>	
			<?php if ($story->id > 0) { ?>
		</div>
		<div class="form_block" >
			<label>Status:</label>
			<select name="status" >
				<option value="p" <?php if(strcmp($story->status,'p')===0) echo('selected="selected"'); ?>>Published</option>
				<option value="d" <?php if(strcmp($story->status,'d')===0) echo('selected="selected"'); ?>>Draft</option>
			</select>			
			<?php } ?>	
		</div>
		<div class="form_block" >		
			<p>
			<input type="submit" name="submit" value="Save" />
			</p>		
		</div>
	</form>
</fieldset>
<?php } ?>
