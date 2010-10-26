<?php 

	if (isset($itemstate))
	{ 
?>
<fieldset>
	<legend>itemstate</legend>
	<form action="<?php print($itemstate_form_action); ?>?keepThis=true&TB_iframe=true" method="post" enctype="multipart/form-data" class="thickbox" >		
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="item_id" value="<?php echo($itemstate->item_id); ?>" />
		<input type="hidden" name="id" value="<?php echo($itemstate->id); ?>" />
		<label>
			Value:
			<input type="text" name="value" value="<?php echo($itemstate->value); ?>" >
		</label>
		<?php if($itemstate->id > 0) { ?>
		<label>
			Image filename:
			<input type="hidden" name="image_id" value="<?php echo($itemstate->image_id); ?>" >
			<input type="text" name="filename" value="<?php echo($itemstate->filename); ?>" >
			<a href="<?php echo($itemstate_assign_image_link); ?>&KeepThis=true&TB_iframe=true" class="thickbox" >Assign Image</a>
		</label>
		<?php } ?>
		<input id="button_submit" type="submit" name="submit" value="submit" />
	</form>
</fieldset>
<?php } ?>
