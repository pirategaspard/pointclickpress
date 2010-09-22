<?php 
	$scenes = $story->getScenes();
?>
<h3><?php print($scene->title); ?></h3>
<fieldset>
	<legend>scene <?php print($scene->id); ?> scene <?php print($scene->value); ?></legend>
	<form action="<?php print($scene_form_action); ?>" method="post" enctype="multipart/form-data" >
		<input type="hidden" name="story_id" value="<?php print($scene->story_id); ?>" >
		<input type="hidden" name="container_id" value="<?php print($scene->container_id); ?>" >
		<input type="hidden" name="id" value="<?php print($scene->id); ?>" >		
		<label>
			Title
			<input type="text" name="title" value="<?php print($scene->title); ?>" />
		</label>
		<label>
			Description
			<textarea name="description"><?php print($scene->description); ?></textarea>
		</label>
		<label>
			Image filename:
			<input type="hidden" name="image_id" value="<?php print($scene->image_id); ?>" >
			<input type="text" name="image_filename" value="<?php print($scene->filename); ?>" >
			<a href="<?php print($assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>
		</label>		
		<label>
			Scene Value:
			<input type="text" name="value" value="<?php print($scene->value); ?>" >
		</label>
		<input type="submit" name="submit" value="Save" />
	</form>
</fieldset>
