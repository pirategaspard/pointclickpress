<?php 

	if (isset($item))
	{ 
?>
<fieldset>
	<legend>Item</legend>
	<form method="post" action="<?php echo($item_form_action); ?>">
		<?php if (isset($scene)){ ?><input type="hidden" name="scene_id" value="<?php echo($scene->id); ?>" /> <?php } ?>
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="id" value="<?php echo($item->id); ?>" />
		<label>
			Image filename:
			<input type="text" name="image_id" value="<?php echo($item->image_id); ?>" >
			<input type="text" name="filename" value="<?php echo($item->filename); ?>" >
			<a href="<?php echo($item_assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>
		</label>
		<label id="cell_ids" for="cell_ids">Cell Id:
			<input type="text" name="cell_id" value="<?php echo($item->cell_id); ?>" />
		</label>
		<input id="button_submit" type="submit" name="submit" value="submit" />
		<?php if($item->id > 0 ) { ?>
		<input id="button_cancel" type="button" name="cancel" value="cancel" scene_id="<?php echo($scene->id); ?>" />
		<?php } ?>
	</form>
</fieldset>
<?php } ?>
