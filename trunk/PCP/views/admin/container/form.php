<?php 
	//var_dump($container);
?>
<fieldset>
	<legend>Container <?php print($container->id); ?></legend>
	<form action="<?php print($container_form_action); ?>" method="post" >
		<input type="hidden" name="story_id" value="<?php print($container->story_id); ?>" >
		<input type="hidden" name="id" value="<?php print($container->id); ?>" >
		Title: <input type="text" name="title" value="<?php print($container->title); ?>" >
		Slug: <?php print($container->slug); ?>
		<input type="submit" name="submit" value="submit" >
	</form>
</fieldset>
<?php 
	if ($container->id > 0)
	{ 
		echo($add_scene); 
		echo($scene_list); 	
	}
?>
