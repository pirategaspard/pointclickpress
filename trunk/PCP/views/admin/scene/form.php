<?php 
	$scenes = $story->getScenes();
?>
<h3><?php print($scene->title); ?></h3>
<fieldset>
	<legend>scene <?php print($scene->id); ?> scene <?php print($scene->value); ?></legend>
	<img src="" />
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
		<?php if (strlen($scene->filename) > 0) { ?>
		<label>
			Path:
			<input type="text" name="filename" value="<?php print($scene->filename); ?>" readonly="readonly" >
		</label>
		<?php } else { ?>
		<label>
			Upload Image:
			<input type="file" name="filename" value="" >
		</label>	
		<?php } ?>
		<label>
			Scene Value:
			<input type="text" name="value" value="<?php print($scene->value); ?>" >
		</label>
		<input type="submit" name="submit" value="Save" />
	</form>
</fieldset>
