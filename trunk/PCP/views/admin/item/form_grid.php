<?php 

	if (isset($item))
	{ 
?>
<a href="<?php echo($back_url); ?>" >Back</a>
<fieldset>
	<legend>Item</legend>
	<form action="<?php print($item_form_action); ?>" method="post" enctype="multipart/form-data" class="thickbox" >
		<input type="hidden" name="scene_id" value="<?php echo($item->scene_id); ?>" />
		<input type="hidden" name="id" value="<?php echo($item->id); ?>" />
		<label>
			Image filename:
			<input type="text" name="filename" value="<?php echo($item->filename); ?>" >
			<a href="<?php echo($assign_item_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Item</a>
		</label>
		<label id="cell_ids" for="cell_ids">Cell Id:
			<input type="text" name="cell_id" value="<?php echo($item->cell_id); ?>" />
		</label>
		<input id="button_submit" type="submit" name="submit" value="submit" />
	</form>
</fieldset>
<?php } ?>
