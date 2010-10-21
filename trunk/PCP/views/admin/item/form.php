<?php 

	if (isset($item))
	{ 
?>
<fieldset>
	<legend>Item</legend>
	<form action="<?php print($item_form_action); ?>?keepThis=true&TB_iframe=true" method="post" enctype="multipart/form-data" class="thickbox" >		
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="story_id" value="<?php echo($item->story_id); ?>" />
		<input type="hidden" name="id" value="<?php echo($item->id); ?>" />
		<label>
			Label:
			<input type="text" name="label" value="<?php echo($item->label); ?>" >
		</label>
		<?php if($item->id > 0) { ?>
		<label>
			Image filename:
			<input type="hidden" name="image_id" value="<?php echo($item->image_id); ?>" >
			<input type="text" name="filename" value="<?php echo($item->filename); ?>" >
			<a href="<?php echo($item_assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>
		</label>
		<?php } ?>
		<input id="button_submit" type="submit" name="submit" value="submit" />
	</form>
</fieldset>
<?php } ?>
