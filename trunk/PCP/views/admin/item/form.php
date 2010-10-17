<?php 

	if (isset($scene))
	{ 
?>
<fieldset>
	<legend>Item</legend>
	<form method="post" action="<?php echo($item_form_action); ?>">
		<?php if (isset($story_id)){ ?><input type="hidden" name="story_id" value="<?php echo($story_id); ?>" /> <?php } ?>
		<?php if (isset($location_id)){ ?><input type="hidden" name="location_id" value="<?php echo($location_id); ?>" /> <?php } ?>
		<?php if (isset($scene_id)){ ?><input type="hidden" name="scene_id" value="<?php echo($scene_id); ?>" /> <?php } ?>
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="id" value="<?php //echo($item->id); ?>" />
		<label>
			Image filename:
			<input type="hidden" name="image_id" value="<?php //print($item->image_id); ?>" >
			<input type="text" name="image_filename" value="<?php //print($item->filename); ?>" >
			<a href="<?php print($assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>
		</label>
		<label id="cell_ids" for="cell_ids">Cell Id List:
			<input type="text" name="cell_ids" value="<?php //echo($event->getCellIds()); ?>" />
		</label>
		<input id="button_submit" type="submit" name="submit" value="submit" />
		<?php /*if($item->id > 0 ) { ?>
		<input id="button_cancel" type="button" name="cancel" value="cancel" scene_id="<?php echo($scene_id); ?>" />
		<?php } */ ?>
	</form>
</fieldset>
<?php } ?>
