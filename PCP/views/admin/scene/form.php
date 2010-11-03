<?php 
	
?>
<h3><?php print($scene->title.' '.$scene->value); ?></h3>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>scene <?php print($scene->id);?></legend>
	<form action="<?php print($scene_form_action); ?>" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="story_id" value="<?php print($scene->story_id); ?>" >
		<input type="hidden" name="location_id" value="<?php print($scene->location_id); ?>" >
		<input type="hidden" name="id" value="<?php print($scene->id); ?>" >
		<div class="form_block" >
			<p>			
				<label>Title</label>
				<input type="text" name="title" size="50" value="<?php print($scene->title); ?>" />
			</p>
			<p>
				<label>Description</label>
				<textarea name="description" cols="50"><?php print($scene->description); ?></textarea>
			</p>
			<p>
				<label>Scene Value:</label>			
				<input type="text" name="value" value="<?php print($scene->value); ?>" >
			</p>
		</div>
		<div class="form_block" >
		<?php if ($scene->id > 0) { ?>
			<label>Image filename:</label>			
			<input type="hidden" name="image_id" value="<?php print($scene->image_id); ?>" >
			<input type="text" name="image_filename" value="<?php print($scene->filename); ?>" >
			<a href="<?php print($assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>		
		<?php } ?>			
		</div>
		<div class="form_block" >
			<p>		
			<input type="submit" name="submit" value="Save" />
			</p>
		</div>
	</form>
</fieldset>