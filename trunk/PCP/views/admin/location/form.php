<?php 
	//var_dump($location);
	if (isset($location))
	{
?>
<fieldset>
	<legend>Location <?php print($location->id); ?></legend>
	<form action="<?php print($location_form_action); ?>" method="post" >
		<input type="hidden" name="story_id" value="<?php print($location->story_id); ?>" >
		<input type="hidden" name="id" value="<?php print($location->id); ?>" >
		Title: <input type="text" name="title" value="<?php print($location->title); ?>" >
		Slug: <?php print($location->slug); ?>
		<input type="submit" name="submit" value="submit" >
	</form>
</fieldset>
<?php 
	} 	
?>
