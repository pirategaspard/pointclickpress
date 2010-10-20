<?php 

	if (isset($item))
	{ 
?>
<a href="<?php echo($back_url); ?>" >Back</a>
<fieldset>
	<legend>Grid Item</legend>
	<form action="<?php print($item_form_action); ?>" method="post" enctype="multipart/form-data" class="thickbox" >
		<input type="hidden" name="story_id" value="<?php echo($item->story_id); ?>" />
		<input type="hidden" name="scene_id" value="<?php echo($item->scene_id); ?>" />
		<input type="hidden" name="image_id" value="<?php echo($item->image_id); ?>" />
		<input type="hidden" name="item_id" value="<?php echo($item->id); ?>" />
		<input type="hidden" name="id" value="<?php echo($item->id); ?>" />
		<label>
			Item:
			<input type="text" name="label" value="<?php echo($item->label); ?>" readonly="readonly" />
			<a href="<?php echo($assign_item_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Item</a>
		</label>
		<label id="cell_id" for="cell_id">Cell Id:
			<input type="text" name="cell_id" value="<?php echo($item->cell_id); ?>" />
		</label>
		<input id="button_submit" type="submit" name="submit" value="submit" />
	</form>
</fieldset>
<?php } ?>
