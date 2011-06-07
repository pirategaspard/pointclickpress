<?php 
	//var_dump($location);
	if (isset($location))
	{
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
	<legend>Location <?php print($location->id); ?></legend>
	<form action="<?php print($location_form_action); ?>" method="post" >
		<input type="hidden" name="story_id" value="<?php print($location->story_id); ?>" >
		<input type="hidden" name="id" value="<?php print($location->id); ?>" >
		<div class="form_block" >
			<p>	
				<label>Title: </label><input type="text" name="title" value="<?php print($location->title); ?>" >
				<label>Value: </label><?php print($location->slug); ?>
			</p>
		</div>
		<div class="form_block" >
			<input type="submit" name="submit" value="Save" class="ui-widget ui-state-default ui-corner-all button save" >
		</div>
	</form>
</fieldset>
<?php 
	} 	
?>
